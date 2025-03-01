// routes
// import { PATH_DASHBOARD } from './routes/paths';

// API
// ----------------------------------------------------------------------

export const HOST_API = import.meta.env.REACT_APP_HOST_API_KEY || ''

export const FIREBASE_API = {
  apiKey: import.meta.env.REACT_APP_FIREBASE_API_KEY,
  authDomain: import.meta.env.REACT_APP_FIREBASE_AUTH_DOMAIN,
  databaseURL: import.meta.env.REACT_APP_FIREBASE_DATABASE_URL,
  projectId: import.meta.env.REACT_APP_FIREBASE_PROJECT_ID,
  storageBucket: import.meta.env.REACT_APP_FIREBASE_STORAGE_BUCKET,
  messagingSenderId: import.meta.env.REACT_APP_FIREBASE_MESSAGING_SENDER_ID,
  appId: import.meta.env.REACT_APP_FIREBASE_APPID,
  measurementId: import.meta.env.REACT_APP_FIREBASE_MEASUREMENT_ID
}

export const COGNITO_API = {
  userPoolId: import.meta.env.REACT_APP_AWS_COGNITO_USER_POOL_ID,
  clientId: import.meta.env.REACT_APP_AWS_COGNITO_CLIENT_ID
}

export const AUTH0_API = {
  clientId: import.meta.env.REACT_APP_AUTH0_CLIENT_ID,
  domain: import.meta.env.REACT_APP_AUTH0_DOMAIN
}

export const MAPBOX_API = import.meta.env.REACT_APP_MAPBOX

// ROOT PATH AFTER LOGIN SUCCESSFUL
// export const PATH_AFTER_LOGIN = PATH_DASHBOARD.general.app; // as '/dashboard/app'

// SETTINGS
// Please remove `localStorage` when you set settings.
// ----------------------------------------------------------------------
