// Import the functions you need from the SDKs you need
import { initializeApp } from "firebase/app";
import { getAnalytics } from "firebase/analytics";
import { getAuth } from "firebase-admin/auth";
import { getFirestore } from "firebase-admin/firestore";
// TODO: Add SDKs for Firebase products that you want to use
// https://firebase.google.com/docs/web/setup#available-libraries

// Your web app's Firebase configuration
// For Firebase JS SDK v7.20.0 and later, measurementId is optional
const firebaseConfig = {
  apiKey: "AIzaSyBKvOD3cu2bQ9UODirOIO-eHWVLWseiVDM",
  authDomain: "recooty-ai-interviewer.firebaseapp.com",
  projectId: "recooty-ai-interviewer",
  storageBucket: "recooty-ai-interviewer.firebasestorage.app",
  messagingSenderId: "1052482900395",
  appId: "1:1052482900395:web:4d66fc08670e3f941742ee",
  measurementId: "G-ZGKP2TKG83"
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);
const analytics = getAnalytics(app);

import { getAuth } from "firebase-admin/auth";
import { getFirestore } from "firebase-admin/firestore";