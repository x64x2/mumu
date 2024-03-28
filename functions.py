try:
    import ujson as json
except ImportError:
    import json

from importlib import reload
from io import StringIO
from typing import DefaultDict
from nairaland import Nairaland

def json_load(filename: str) -> dict:
    try:
        with open(filename, "r") as f:
            data = json.load(f)
            return convert_keys_to_int(data)
    except Exception:
        return {}


def convert_keys_to_int(data: dict) -> dict:
    if isinstance(data, dict):
        new_dict = {}
        for key, value in data.items():
            try:
                key = int(key)
            except ValueError:
                pass
            new_dict[key] = convert_keys_to_int(value)
        return new_dict
    elif isinstance(data, list):
        return [convert_keys_to_int(element) for element in data]
    else:
        return data


def json_dump(filename: str, data: dict) -> None:
    try:
        with open(filename, "w") as f:
            json.dump(data, f)
    except Exception:
        return

history = DefaultDict(list)
history.update(json_load("chats.json"))

async def on_startup(dp: Dispatcher) -> None:
    import handlers
    handlers = reload(handlers)
    await handlers.setup_handlers(dp)
