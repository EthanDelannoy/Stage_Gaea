import React from 'react';
import { createRoot } from 'react-dom/client';
import { HashRouter as Router, Routes, Route } from 'react-router-dom';
import UserTableau from './components/UserTableau';
import PossessionTableau from './components/PossessionTableau'; 
import 'bootstrap/dist/css/bootstrap.min.css';
import './styles/custom.css';

const rootElement = document.getElementById('root');

const root = createRoot(rootElement);

root.render(
  <React.StrictMode>
    <Router>
      <Routes>
        <Route path="/" element={<UserTableau />} />
        <Route path="/users/:id" element={<PossessionTableau />} />
      </Routes>
    </Router>
  </React.StrictMode>
);