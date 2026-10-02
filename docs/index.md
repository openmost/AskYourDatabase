## Documentation

This plugin embeds your [AskYourDatabase](https://www.askyourdatabase.com/) chatbot in Matomo. AskYourDatabase turns questions written in plain language into SQL queries, runs them on your database and answers with tables and charts.

### 1 - Connect your database to AskYourDatabase

Create an account on [AskYourDatabase](https://www.askyourdatabase.com/) and connect the database you want to query, for example your Matomo database.

We strongly recommend a **dedicated read-only MySQL / MariaDB user**, limited to the tables the chatbot needs. Do not give access to the tables storing your Matomo users, passwords and tokens. For example, with the default `matomo_` table prefix:

```sql
CREATE USER 'askyourdatabase'@'%' IDENTIFIED BY 'a-long-random-password';
GRANT SELECT ON matomo.matomo_site TO 'askyourdatabase'@'%';
GRANT SELECT ON matomo.matomo_goal TO 'askyourdatabase'@'%';
GRANT SELECT ON matomo.matomo_log_visit TO 'askyourdatabase'@'%';
GRANT SELECT ON matomo.matomo_log_link_visit_action TO 'askyourdatabase'@'%';
GRANT SELECT ON matomo.matomo_log_action TO 'askyourdatabase'@'%';
GRANT SELECT ON matomo.matomo_log_conversion TO 'askyourdatabase'@'%';
```

If your hosting allows it, replace `%` by the IP addresses used by AskYourDatabase.

### 2 - Get your chatbot ID and API key

- **Chatbot ID**: open your chatbot in the AskYourDatabase dashboard. The ID is the last part of the URL, for example `5da7b8cf3a372f5e6e6b64af9ae189c7` in `https://www.askyourdatabase.com/dashboard/chatbot/5da7b8cf3a372f5e6e6b64af9ae189c7`. You can also copy the full URL, the plugin extracts the ID.
- **API key**: create one in the **API Key** page of the AskYourDatabase dashboard.

### 3 - Install and configure the plugin

1. Install the plugin from the Marketplace as a super user, or upload it to the `/plugins` folder of your Matomo.
2. Enable it under **Administration > System > Plugins**.
3. Go to **Administration > System > General settings > AskYourDatabase** and fill in:
   - **API key** (required)
   - **Chatbot ID** (required)
   - **Name** and **Email** (optional): identity used for the chat sessions. Leave them empty to use the login and email of the Matomo user who opens the chatbot, so that each user keeps their own conversations.

### 4 - Chat with your data

Click **AskYourDatabase** in the top menu. The plugin creates a secure session and opens the chatbot. When the session expires, a new one is created automatically.

Only super users can see the menu and open the chatbot, as it can read the connected database.

### How it works

1. Matomo calls the AskYourDatabase v2 session API from the server, with your API key.
2. AskYourDatabase returns a one-time URL, opened in the page. Your API key is never sent to the browser.
3. The Matomo Content Security Policy is extended to allow the `https://www.askyourdatabase.com` iframe.

### Requirements

- Matomo 5.0.0 or later
- Outgoing HTTPS requests from your Matomo server to `www.askyourdatabase.com`
