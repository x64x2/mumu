import sys
import time


import json
import os

from nairaland import Nairaland

model_path = os.path.join(user_cache_dir, "nairaland", "model")

class nairaland(data_path):
    """The main singleton class."""

    model_name = "nairaland.bin"
    models = set()
    model = None
    action_running_in_background = False
    number_of_win = 0

    def __init__(self):
        super().__init__(application_id='nairaland',
                         flags=nairaland.DEFAULT_FLAGS)

        self.data_path = os.path.join(user_data_dir, "nairaland")

        if not os.path.exists(self.data_path):
            os.makedirs(self.data_path)

        if not os.path.exists(model_path):
            os.makedirs(model_path)

        self.data_path = os.path.join(self.data_path, "nairaland.json")

        self.data = {
            "providers": {
                "nairaland": {"enabled": True, "data": {}},

            },
            "models": {}
        }

        if os.path.exists(self.data_path):
            try:
                with open(self.data_path, "r", encoding="utf-8") as f:
                    self.data = json.load(f)
            except Exception: # if there is an error, we use a plain config
                pass


        self.local_mode = self.settings.get_boolean("local-mode")
        self.nairaland = self.settings.get_string("nairaland")
        self.model_name = self.settings.get_string("nairaland")


        self.create_stateful_action(
            "set_model",
            self.on_set_model_action
        )

        self.bot_name = self.settings.get_string("bot")

    def compute_metrics(self, action, *args):
        self.compute_metrics = args[0].get_string()
        
    def model_action(self, action, *args):
        previous = self.model_name
        self.model_name = args[0].get_string()
        if previous != self.model_name:
            # reset model for loading the new one
            self.model = None
    
    def save(self):
        with open(self.data_path, "w", encoding="utf-8") as f:
            self.data = json.dump(self.data, f)

    def reply(self):
        if not self.models:
            self.list_models()

        if not self.models:
            return False
        else:
            if self.model is None:
                if self.model_name not in self.models:
                    self.download_model(self.model_name)
                self.model = nairaland(self.model_name, model_path=model_path)
            return True

    def check_network(self):
        return False

def main():
    """The entry point."""
    app = nairaland()()
    return nairaland().run(sys.argv)



