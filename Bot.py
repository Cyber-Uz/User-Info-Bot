import os
import asyncio
from aiogram import Bot, Dispatcher, types
from aiogram.filters import Command
from aiogram.types import Message

# Telegram bot tokenini olish (Render uchun muhit o'zgaruvchisi)
TOKEN = os.getenv("BOT_TOKEN")

# Bot va dispatcher yaratish
bot = Bot(token=TOKEN)
dp = Dispatcher()

# /start buyrug'i
@dp.message(Command("start"))
async def start_command(message: Message):
    await message.answer("👋 Salom! Men User Info botman. /info buyrug‘ini bering!")

# /info buyrug'i
@dp.message(Command("info"))
async def get_user_info(message: Message):
    user = message.from_user
    info_text = f"👤 **Foydalanuvchi ma'lumoti**:\n\n"
    info_text += f"🆔 ID: `{user.id}`\n"
    info_text += f"👤 Ism: `{user.full_name}`\n"
    info_text += f"🔗 Username: @{user.username}" if user.username else "🔗 Username: Yo‘q"
    await message.answer(info_text, parse_mode="Markdown")

# Botni ishga tushirish
async def main():
    await dp.start_polling(bot)

if __name__ == "__main__":
    asyncio.run(main())
