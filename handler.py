from time import time

from nairaland import Nairaland
import os
from nairaland.browser import Browser

model = config.get("nairaland", "model")
user_config = DefaultDict(default_user_config)


browser = Browser(os.getenv('LINUX'))
nairaland = Nairaland(browser)

user_profile = nairaland.topic_posts(user='cococandy',topic='5426482')

