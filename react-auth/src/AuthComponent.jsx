import React, { useEffect } from 'react';
import { SignInButton, SignOutButton, useUser } from '@clerk/clerk-react';

function AuthComponent() {
  const { isSignedIn, user, isLoaded } = useUser();

  // Console log user info when they login
  useEffect(() => {
    if (isLoaded && isSignedIn && user) {
      console.log('ID:', user.id);
      console.log('First Name:', user.firstName);
      console.log('Email:', user.emailAddresses[0]?.emailAddress);
    }
  }, [isLoaded, isSignedIn, user]);

  if (!isLoaded) {
    return null; // Or a loading spinner
  }

  return (
    <div style={{ display: 'flex', alignItems: 'center', gap: '10px' }}>
      {isSignedIn ? (
        <>
          <span style={{ color: 'white', marginLeft: '10px' }}>
            {user.firstName || user.emailAddresses[0]?.emailAddress || 'User'}
          </span>
          <SignOutButton>
            <button 
              style={{
                padding: '5px 10px',
                background: '#2a2a2a',
                color: 'white',
                border: 'none',
                borderRadius: '4px',
                cursor: 'pointer'
              }}
            >
              Sign Out
            </button>
          </SignOutButton>
        </>
      ) : (
        <SignInButton mode="modal">
          <button 
            className="download-btn"
            style={{
              display: 'flex',
              background: '#2a2a2a',
              color: '#ffffff',
              border: 'none',
              padding: '10px 20px',
              borderRadius: '6px',
              fontSize: '14px',
              fontWeight: '400',
              cursor: 'pointer',
              alignItems: 'center',
              gap: '8px',
              transition: 'background-color 0.3s'
            }}
            onMouseEnter={(e) => e.target.style.backgroundColor = '#3a3a3a'}
            onMouseLeave={(e) => e.target.style.backgroundColor = '#2a2a2a'}
          >
            Sign In
          </button>
        </SignInButton>
      )}
    </div>
  );
}

export default AuthComponent;
