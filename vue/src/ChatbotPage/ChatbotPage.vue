<!--
  Matomo - free/libre analytics platform

  @link    https://matomo.org
  @license https://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
-->

<template>
  <div class="askYourDatabase">
    <ContentBlock
      v-if="!isConfigured"
      :content-title="translate('AskYourDatabase_NotConfigured')"
    >
      <p>{{ translate('AskYourDatabase_NotConfiguredDescription') }}</p>
      <p v-html="$sanitize(noAccountText)" />
      <a class="btn askYourDatabaseSettingsButton" :href="settingsUrl">{{ translate('AskYourDatabase_GoToSettings') }}</a>
    </ContentBlock>

    <div v-else class="askYourDatabaseChatbot">
      <Alert v-if="errorMessage" severity="danger" class="askYourDatabaseError">
        <span>{{ errorMessage }}</span>
        <button type="button" class="btn" @click="createSession">
          {{ translate('AskYourDatabase_Retry') }}
        </button>
      </Alert>

      <ActivityIndicator
        v-if="!errorMessage"
        :loading="isLoading"
        :loading-message="translate('AskYourDatabase_Loading')"
      />

      <iframe
        v-if="iframeUrl"
        v-show="!errorMessage"
        class="askYourDatabaseFrame"
        :src="iframeUrl"
        :title="translate('AskYourDatabase_ChatbotFrameTitle')"
        allow="clipboard-write"
        @load="isLoading = false"
      />
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import {
  ActivityIndicator,
  AjaxHelper,
  Alert,
  ContentBlock,
  translate,
} from 'CoreHome';

const CHATBOT_ORIGIN = 'https://www.askyourdatabase.com';

interface SessionResponse {
  url: string;
}

interface ChatbotMessage {
  type?: string;
  url?: string;
}

export default defineComponent({
  components: {
    ActivityIndicator,
    Alert,
    ContentBlock,
  },
  props: {
    isConfigured: {
      type: Boolean,
      required: true,
    },
    settingsUrl: {
      type: String,
      required: true,
    },
  },
  data() {
    return {
      iframeUrl: '',
      isLoading: false,
      isCreatingSession: false,
      errorMessage: '',
    };
  },
  computed: {
    noAccountText(): string {
      return translate(
        'AskYourDatabase_NotConfiguredNoAccount',
        `<a href="${CHATBOT_ORIGIN}/" target="_blank" rel="noreferrer noopener">`,
        '</a>',
      );
    },
  },
  mounted() {
    if (!this.isConfigured) {
      return;
    }

    window.addEventListener('message', this.onChatbotMessage);
    this.createSession();
  },
  beforeUnmount() {
    window.removeEventListener('message', this.onChatbotMessage);
  },
  methods: {
    createSession() {
      if (this.isCreatingSession) {
        return;
      }

      this.isCreatingSession = true;
      this.isLoading = true;
      this.errorMessage = '';

      AjaxHelper.post<SessionResponse>(
        { method: 'AskYourDatabase.createSession' },
        {},
        { createErrorNotification: false },
      ).then((response) => {
        this.iframeUrl = response.url;
      }).catch((error: Error) => {
        this.errorMessage = error?.message || translate('General_ErrorRequest', '', '');
        this.isLoading = false;
      }).finally(() => {
        this.isCreatingSession = false;
      });
    },
    // The chatbot asks for a new session when it expires, then gives the URL to open once logged in
    onChatbotMessage(event: MessageEvent<ChatbotMessage>) {
      if (event.origin !== CHATBOT_ORIGIN || !event.data) {
        return;
      }

      if (event.data.type === 'LOGIN_REQUIRED') {
        this.createSession();
      } else if (
        event.data.type === 'LOGIN_SUCCESS'
        && typeof event.data.url === 'string'
        && event.data.url.startsWith(`${CHATBOT_ORIGIN}/`)
      ) {
        this.iframeUrl = event.data.url;
      }
    },
  },
});
</script>

<style lang="less">
.askYourDatabaseSettingsButton {
  margin-top: 1rem;
}

.askYourDatabaseChatbot {
  .askYourDatabaseError {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
  }

  .askYourDatabaseFrame {
    display: block;
    width: 100%;
    height: calc(100vh - 180px);
    min-height: 480px;
    border: 0;
    border-radius: 4px;
  }
}
</style>
