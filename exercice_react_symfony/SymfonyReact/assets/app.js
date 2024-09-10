import React from 'react';
import ReactDOM from 'react-dom/client';
import App from './components/UserTableau';
import 'bootstrap/dist/css/bootstrap.min.css';
import './styles/custom.css';

const rootElement = document.getElementById('root');

const root = ReactDOM.createRoot(rootElement);

root.render(<App />);