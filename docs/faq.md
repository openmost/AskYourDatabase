## FAQ

__How to install this plugin?__

This plugin is available in the official Matomo Marketplace. Install it the same way as other plugins:

- Go to the administration panel
- Open **Marketplace**
- Search for "**AskYourDatabase**", install and activate the plugin
- Enter your API key and chatbot ID in **Administration > System > General settings > AskYourDatabase**

__I upgraded the plugin and the chatbot does not open anymore__

Since version 5.0.8 (for Matomo 5), the plugin uses the AskYourDatabase **v2 API**. The previous API has been shut down by AskYourDatabase and answers "Please call v2 API". The former "Secret key" setting is no longer used: create an **API key** in your AskYourDatabase dashboard and enter it with your **chatbot ID** in the plugin settings.

__Where do I find my chatbot ID?__

Open your chatbot in the AskYourDatabase dashboard, the ID is the last part of the URL (for example `5da7b8cf3a372f5e6e6b64af9ae189c7`). You can paste the full URL in the setting, the plugin extracts the ID.

__Is the plugin available for all Matomo users?__

No, **only super users** can see the menu and open the chatbot, because it can read the connected database.

__What are the Name and Email settings used for?__

They identify the chat sessions in AskYourDatabase. Leave them empty to use the login and email of the Matomo user who opens the chatbot: each user keeps their own conversations. Fill them in to share the same identity for all users.

__Is my database safe?__

The plugin never connects to your database itself: AskYourDatabase does, with the credentials you configured in their dashboard. Use a dedicated read-only user limited to the tables the chatbot needs, and never give access to the tables storing your Matomo users and tokens. An example is available in the documentation. Your AskYourDatabase API key stays on your Matomo server.

__The page displays "AskYourDatabase could not be reached"__

Your Matomo server must be able to send HTTPS requests to `www.askyourdatabase.com`. Check your firewall, and the proxy settings of your Matomo configuration if you use one.

__The chatbot area stays blank__

A browser extension or a Content Security Policy added by your web server may block the iframe. The plugin allows `https://www.askyourdatabase.com` in the Matomo Content Security Policy, allow it in your web server configuration too.

__How to use this plugin?__

Create an account on [AskYourDatabase](https://www.askyourdatabase.com/), connect your database, create a chatbot and an API key, then follow the documentation.

__How can I contribute to this plugin?__

Issues and pull requests are welcome on [GitHub](https://github.com/openmost/AskYourDatabase). You can also contact us at ronan@openmost.com.

__How long will this plugin be maintained?__

As long as possible. We use Matomo on many projects every day and fix issues as fast as we can.
