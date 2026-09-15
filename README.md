# Matomo AskYourDatabase Plugin

## Description

**Chat with your data, right inside Matomo.** AskYourDatabase is an AI chatbot connected to your database: ask a question in plain language, it writes the SQL query, runs it and answers with tables and charts. This plugin brings your AskYourDatabase chatbot into Matomo, so your team can explore the data behind your analytics without leaving Matomo and without writing a single line of SQL.

### ✨ NEW: Matomo 6 and the AskYourDatabase v2 API

- Compatible with **Matomo 6**
- Uses the AskYourDatabase **v2 session API** (API key + chatbot ID). The API used by the previous versions has been shut down by AskYourDatabase: enter your new credentials in the settings after upgrading
- Each super user chats with **their own session**, identified by their Matomo login and email (or a shared name and email of your choice)
- Expired sessions are **renewed automatically**
- Clear error messages with a **Retry** button when the chatbot cannot be opened
- A setup guide is displayed on the page until the plugin is configured
- Paste the chatbot **ID or its full URL**, the plugin finds the ID
- English and French translations

### 💬 Ask your data anything

- "What are the 10 most visited pages last month?"
- "Which campaigns brought the most conversions this year?"
- "Compare the visits of our websites week by week"
- Get the answers as tables and charts, with the SQL query used

### 🔒 Secure by design

- Only **super users** can open the chatbot
- Your **API key stays on the server**: the browser only receives a one-time session URL
- HTTPS certificates are verified on every call to AskYourDatabase
- The Matomo Content Security Policy only allows the chatbot of askyourdatabase.com to be embedded

### Requirements

- Matomo 6, PHP 8.1 or later, MySQL 8.0+ or MariaDB 10.6+
- An [AskYourDatabase](https://www.askyourdatabase.com/) account with a chatbot and an API key

### Get started

1. Install the plugin from the **Matomo Marketplace** (as a super user), or upload it to your `/plugins` folder.
2. Enable it under **Administration > System > Plugins**.
3. Enter your **API key** and **chatbot ID** in **Administration > System > General settings > AskYourDatabase**.
4. Click **AskYourDatabase** in the top menu and start chatting with your data.

**The full setup guide, including how to give AskYourDatabase a safe read-only access to your database, is available in the documentation.**
