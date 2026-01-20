# React Auth Component

This React app provides Clerk authentication that gets bundled and included in the main HTML page.

## Setup

1. Install dependencies:
```bash
npm install
```

## Development

To rebuild the bundle after making changes:
```bash
npm run build
```

The bundle will be output to `dist/react-auth-bundle.iife.js` and is automatically included in `../index.html`.

## How it works

- The React app uses Clerk's official React package (`@clerk/clerk-react`)
- It's built as an IIFE (Immediately Invoked Function Expression) bundle
- The bundle automatically initializes when loaded and mounts to the `#auth-container` div in `index.html`
- Uses the Clerk publishable key defined in `src/main.jsx`
