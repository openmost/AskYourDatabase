## Changelog

### v5.0.8

- Update the plugin homepage (https://openmost.com/matomo/extensions/ask-your-database), the support email and the Marketplace category
- Sessions are created with the AskYourDatabase v2 API (`/api/chatbot/v2/session`), as in v6: the previous API has been shut down. New **API key** and **Chatbot ID** settings replace the secret key, **Name** and **Email** become optional (the Matomo login and email are used when empty)
- Security: HTTPS certificates of AskYourDatabase are verified again, requests go through the Matomo HTTP client, and only askyourdatabase.com URLs are loaded in the iframe
- When the chatbot cannot be opened, the page shows the translated reason and a Retry button instead of a blank iframe, and a setup guide until the plugin is configured
- The menu is displayed to super users only, also before the configuration. API method `AskYourDatabase.getIframeUrl` replaced by `AskYourDatabase.createSession`
- Translated into 12 languages

### v5.0.7

update: Documentation

### v5.0.6

update: Remove search bar from view

### V5.0.5

update: Remove search bar from view

### v5.0.4

fix: Scrollbar height

### v5.0.3

update: Documentation

### v5.0.2

update: Description and plugins.json meta

### v5.0.1

Minor fixes

### v5.0.0

Create plugin base
