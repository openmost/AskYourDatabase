## Changelog

### v6.0.1

- Translations: the plugin is now available in 12 languages (Arabic, Chinese simplified and traditional, Dutch, English, French, German, Italian, Japanese, Polish, Portuguese, Spanish)

### v6.0.0

**Matomo 6**

- Compatibility with Matomo 6.x (`>=6.0.0-b1,<7.0.0-b1`), requires PHP 8.1+ (and MySQL 8.0+ or MariaDB 10.6+ as required by Matomo 6)
- Update the plugin homepage to https://openmost.com/matomo/extensions/ask-your-database and the support email

**AskYourDatabase v2 API**

- Sessions are created with the AskYourDatabase v2 API (`/api/chatbot/v2/session`), the previous API has been shut down by AskYourDatabase
- New **API key** and **Chatbot ID** settings replace the former secret key. The chatbot ID setting accepts the chatbot URL
- **Name** and **Email** settings are now optional: when empty, the login and email of the current Matomo user are used
- Expired sessions are renewed automatically (`LOGIN_REQUIRED` / `LOGIN_SUCCESS` messages of the chatbot)

**Improvements**

- The page is rendered by a Vue component (`AskYourDatabase.ChatbotPage`): loading indicator, error message with a Retry button, setup guide with a link to the settings when the plugin is not configured
- The menu is only displayed to super users, and is visible before the configuration to guide the setup
- The period and website selector is no longer displayed on the chatbot page
- English and French translations for the settings and the page

**Security**

- HTTPS certificates of AskYourDatabase are now verified, requests go through the Matomo HTTP client (proxy settings supported)
- Only URLs of askyourdatabase.com can be loaded in the chatbot iframe
- Email setting validation

**Technical**

- API method `AskYourDatabase.getIframeUrl` replaced by `AskYourDatabase.createSession`
- Remove the inline script and styles of the Twig template
- Unit tests for the session client

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
