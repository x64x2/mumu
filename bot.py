#! /usr/bin/python3

import logging
from asyncio import create_task
from atexit import register
from configparser import ConfigParser
from os import getpid, name
from other import config

import function
from other import logformat

# Basic setup
if name != "nt":
    from importlib import reload
    from signal import SIGHUP, signal

    async def reload_config(*args, **kwargs) -> None:
        logging.info("Reloading config...")
        global token, api_keys
        try:
            global config

            config = ConfigParser()
            config.read("config.ini")
            config.bot_token = config.get("main", "bot_token")
        except Exception as e:
            logging.error(f"Unable to reload config: {str(e)}")
            return

        global bot, dp
        token = config.bot_token
        dp.stop_polling()
        await dp.wait_closed()
        bot = Bot(token=token)
        dp = Dispatcher(bot)
        await startup(dp)
        await dp.start_polling()

    signal(SIGHUP, lambda *args, **kwargs: create_task(reload_config()))

config.bot_token = config.get("main", "bot_token")

openai = openai_override
token = config.bot_token
logging.basicConfig(level=logging.INFO, format=logformat)

bot = Bot(token=token)
dp = Dispatcher(bot)


async def startup(dp: Dispatcher) -> None:
    global me, uname, functions
    me = await dp.bot.get_me()
    uname = me.username
    history = functions.history
    functions = reload(functions)
    functions.history = history
    on_startup = functions.on_startup
    await on_startup(dp)


@register
def save() -> None:
    functions.json_dump("chats.json", functions.history)


if __name__ == "__main__":
    logging.info(f"My pid is {getpid()}")
    executor.start_polling(dp, skip_updates=True, on_startup=startup)
