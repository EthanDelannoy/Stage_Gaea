import React, { useState } from 'react';

function Modal({ show, handleClose, handleSave }) {
  const [user, setUser] = useState({
    nom: '',
    prenom: '',
    email: '',
    adresse: '',
    tel: '',
    birthdate: ''
  });

  const handleChange = (e) => {
    const { name, value } = e.target;
    setUser({ ...user, [name]: value });
  };

  const handleSubmit = (e) => {
    e.preventDefault();
    handleSave(user);
    handleClose();
  };

  if (!show) {
    return null;
  }

  return (
    <div className="modal show d-block" tabIndex="-1">
      <div className="modal-dialog">
        <div className="modal-content">
          <div className="modal-header">
            <h5 className="modal-title">Ajouter un utilisateur</h5>
            <button type="button" className="btn-close" onClick={handleClose}></button>
          </div>
          <div className="modal-body">
            <form onSubmit={handleSubmit}>
              <div className="mb-3">
                <label>Nom</label>
                <input type="text" className="form-control" name="nom" value={user.nom} onChange={handleChange} required />
              </div>
              <div className="mb-3">
                <label>Prénom</label>
                <input type="text" className="form-control" name="prenom" value={user.prenom} onChange={handleChange} required />
              </div>
              <div className="mb-3">
                <label>Email</label>
                <input type="email" className="form-control" name="email" value={user.email} onChange={handleChange} required />
              </div>
              <div className="mb-3">
                <label>Adresse</label>
                <input type="text" className="form-control" name="adresse" value={user.adresse} onChange={handleChange} required />
              </div>
              <div className="mb-3">
                <label>Téléphone</label>
                <input type="text" className="form-control" name="tel" value={user.tel} onChange={handleChange} required />
              </div>
              <div className="mb-3">
                <label>Date de naissance</label>
                <input type="date" className="form-control" name="birthdate" value={user.birthdate} onChange={handleChange} />
              </div>
              <button type="submit" className="btn btn-primary">Ajouter</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  );
}

export default Modal;