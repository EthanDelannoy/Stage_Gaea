import React, { useState } from 'react';
import { BrowserRouter as Router, Route, Routes } from 'react-router-dom';
import User from './User';
import Details from './Details';
import data from './user.json';

function App() {
  const [users] = useState(data);

  return (
    <Router>
      <div className="container mt-5">
        <Routes>
          <Route path="/" element={<User users={users} />} />
          <Route path="/user/:id" element={<Details users={users} />} />
        </Routes>
      </div>
    </Router>
  );
}

export default App;