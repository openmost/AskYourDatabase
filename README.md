# AskYourDatabase for Matomo

Chat with your data inside Matomo: embed your AskYourDatabase AI chatbot and query your database in plain language, without writing SQL.

## Features

- **AskYourDatabase chatbot in Matomo**: a top menu entry opens your AskYourDatabase chatbot in a full-height page. Ask questions such as "What are the 10 most visited pages last month?" and get answers as tables and charts, with the SQL query used.
- **AskYourDatabase v2 session API**: the plugin creates a chatbot session from your API key and chatbot ID. Expired sessions are renewed automatically.
- **One session per user**: by default each super user chats with their own session, identified by their Matomo login and email. You can set a shared name and email instead.
- **Easy setup**: paste the chatbot ID or its full URL, the plugin extracts the ID. Until the plugin is configured, the page shows a setup guide with a link to the settings.
- **Clear errors**: when the chatbot cannot be opened, the page displays the reason and a Retry button.
- **Super users only**: the menu and the page are restricted to super users, because the chatbot can read the connected database.
- Available in 12 languages.

## Requirements

- Matomo 5.0.0 or later, below 6.0.0
- An [AskYourDatabase](https://www.askyourdatabase.com/) account with a chatbot connected to your database, and an API key
- Outgoing HTTPS requests from your Matomo server to `www.askyourdatabase.com`

## Installation / Configuration

1. Install the plugin from the Matomo Marketplace as a super user, or upload it to the `plugins/` folder, then activate it in **Administration > System > Plugins**.
2. In AskYourDatabase, connect your database (a dedicated read-only user is strongly recommended), create a chatbot and an API key.
3. In Matomo, go to **Administration > System > General settings > AskYourDatabase** and fill in:
   - **API key** (required)
   - **Chatbot ID** (required, the ID or the full chatbot URL)
   - **Name** and **Email** (optional): leave them empty to use the login and email of the Matomo user who opens the chatbot.
4. Click **AskYourDatabase** in the top menu.

The full setup guide, including an example of a read-only database user, is in the plugin documentation.

## Privacy and data

- The plugin never connects to your database itself. AskYourDatabase does, with the credentials you configured in their dashboard. Grant it read-only access to the tables it needs, never to the tables storing Matomo users and tokens.
- The questions you type and the answers are processed by AskYourDatabase, in the embedded chatbot.
- To create a session, Matomo sends your API key, chatbot ID and the session name and email (the Matomo login and email by default) to AskYourDatabase from the server. The API key is stored in the Matomo plugin settings and is never sent to the browser, which only receives a one-time session URL.
- Requests to AskYourDatabase verify HTTPS certificates. The Matomo Content Security Policy only allows `https://www.askyourdatabase.com` to be embedded.

## Need help with Matomo?

Openmost is an official Matomo Implementation Partner. We connect Matomo to the rest of your stack, from databases and BI tools to AI assistants, with [Matomo integrations](https://openmost.com/matomo/services/integration?utm_source=matomo_marketplace&utm_medium=referral&utm_campaign=services&utm_content=askyourdatabase) built on official APIs and documented data flows your team can take over.

## Support

- Email: ronan@openmost.com
- Homepage: https://openmost.com/matomo/extensions/ask-your-database
- Issues: https://github.com/openmost/AskYourDatabase/issues

## Screenshots

Screenshots of the chatbot page and of the settings are available in the `screenshots/` folder and on the Marketplace.
