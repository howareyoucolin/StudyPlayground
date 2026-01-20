import React from 'react';
import ReactDOM from 'react-dom/client';
import { ClerkProvider, SignInButton, SignOutButton, useUser } from '@clerk/clerk-react';
import AuthComponent from './AuthComponent';

const CLERK_PUBLISHABLE_KEY = 'pk_test_dHJ1c3RlZC1hbGJhY29yZS0wLmNsZXJrLmFjY291bnRzLmRldiQ';

// This function will be called when the bundle loads
window.initReactAuth = function(containerId) {
  const container = document.getElementById(containerId);
  if (!container) {
    console.error(`Container with id "${containerId}" not found`);
    return;
  }

  const root = ReactDOM.createRoot(container);
  root.render(
    <React.StrictMode>
      <ClerkProvider publishableKey={CLERK_PUBLISHABLE_KEY}>
        <AuthComponent />
      </ClerkProvider>
    </React.StrictMode>
  );
};

// Auto-initialize if container exists
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', () => {
    const container = document.getElementById('auth-container');
    if (container) {
      window.initReactAuth('auth-container');
    }
  });
} else {
  const container = document.getElementById('auth-container');
  if (container) {
    window.initReactAuth('auth-container');
  }
}
