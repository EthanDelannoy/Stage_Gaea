import React, { useState } from 'react';
import { BrowserRouter as Router, Route, Routes } from 'react-router-dom';
import User from './User';
import Details from './Details';
import UserModal from './Modal';
import data from './user.json';

function App() {
  const [users, setUsers] = useState(data);
  const [showModal, setShowModal] = useState(false);

  const handleOpenModal = () => {
    setShowModal(true);
  };

  const handleCloseModal = () => {
    setShowModal(false);
  };

  const handleSaveUser = (newUser) => {
    newUser.id = users.length + 1; 
    setUsers([...users, newUser]); 
  };

  return (
    <Router>
      <div className="container mt-5">
        <button className="btn btn-primary mb-3" onClick={handleOpenModal}>
          Ajouter un utilisateur
        </button>
        <Routes>
          <Route path="/" element={<User users={users} />} />
          <Route path="/user/:id" element={<Details users={users} />} />
        </Routes>
        <UserModal show={showModal} handleClose={handleCloseModal} handleSave={handleSaveUser} />
      </div>
    </Router>
  );
}

export default App;
