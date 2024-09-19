import React, { useEffect, useState } from 'react';
import { Link } from 'react-router-dom';
import 'bootstrap/dist/css/bootstrap.min.css';

const UserTableau = () => {
  const [users, setUsers] = useState([]);
  const [showModal, setShowModal] = useState(false);
  const [formData, setFormData] = useState({
    nom: '',
    prenom: '',
    email: '',
    adresse: '',
    tel: '',
    birthDate: '',
  });

  useEffect(() => {
    fetch('/api/users')
      .then(response => response.json())
      .then(data => setUsers(data))
      .catch(error => console.error('Error fetching users:', error));
  }, []);

  const deleteUser = (id) => {
    fetch(`/api/users/${id}`, { method: 'DELETE' })
      .then(response => {
        if (response.ok) {
          setUsers(users.filter(user => user.id !== id));
        } else {
          console.error('L\'utilisateur n\'a pas pu être supprimé.');
        }
      })
      .catch(error => console.error('Error:', error));
  };

  const handleInputChange = (event) => {
    const { name, value } = event.target;
    setFormData({ ...formData, [name]: value });
  };

  const handleSubmit = (event) => {
    event.preventDefault();
    fetch('/api/users', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(formData),
    })
      .then(response => response.json())
      .then(data => {
        setUsers([...users, data]); // Add the new user to the list
        setShowModal(false); // Close the modal
        setFormData({ // Reset the form
          nom: '',
          prenom: '',
          email: '',
          adresse: '',
          tel: '',
          birthDate: '',
        });
      })
      .catch(error => console.error('Error:', error));
  };

  return (
    <div className="container mt-5">
      <h1 className="text-center">Utilisateurs</h1>
      
      {/* Button to open the modal */}
      <button className="btn btn-primary mb-3" onClick={() => setShowModal(true)}>
        Ajouter un utilisateur
      </button>

      <table className="table table-striped table-bordered mt-3">
        <thead className="thead-dark">
          <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Email</th>
            <th>Adresse</th>
            <th>Téléphone</th>
            <th>Année de naissance</th>
            <th>Âge</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          {users.map(user => (
            <tr key={user.id}>
              <td>{user.id}</td>
              <td><Link to={`/users/${user.id}`}>{user.nom}</Link></td>
              <td>{user.prenom}</td>
              <td>{user.email}</td>
              <td>{user.adresse}</td>
              <td>{user.tel}</td>
              <td>{user.birthDate}</td>
              <td>{user.age}</td>
              <td>
                <button className="btn btn-danger" onClick={() => deleteUser(user.id)}>
                  Supprimer
                </button>
              </td>
            </tr>
          ))}
        </tbody>
      </table>

      {/* Modal */}
      {showModal && (
        <div className="modal fade show d-block" tabIndex="-1">
          <div className="modal-dialog">
            <div className="modal-content">
              <div className="modal-header">
                <h5 className="modal-title">Ajouter un nouvel utilisateur</h5>
                <button type="button" className="btn-close" onClick={() => setShowModal(false)}></button>
              </div>
              <div className="modal-body">
                <form onSubmit={handleSubmit}>
                  <div className="mb-3">
                    <label className="form-label">Nom</label>
                    <input
                      type="text"
                      className="form-control"
                      name="nom"
                      value={formData.nom}
                      onChange={handleInputChange}
                      required
                    />
                  </div>
                  <div className="mb-3">
                    <label className="form-label">Prénom</label>
                    <input
                      type="text"
                      className="form-control"
                      name="prenom"
                      value={formData.prenom}
                      onChange={handleInputChange}
                      required
                    />
                  </div>
                  <div className="mb-3">
                    <label className="form-label">Email</label>
                    <input
                      type="email"
                      className="form-control"
                      name="email"
                      value={formData.email}
                      onChange={handleInputChange}
                      required
                    />
                  </div>
                  <div className="mb-3">
                    <label className="form-label">Adresse</label>
                    <input
                      type="text"
                      className="form-control"
                      name="adresse"
                      value={formData.adresse}
                      onChange={handleInputChange}
                      required
                    />
                  </div>
                  <div className="mb-3">
                    <label className="form-label">Téléphone</label>
                    <input
                      type="text"
                      className="form-control"
                      name="tel"
                      value={formData.tel}
                      onChange={handleInputChange}
                      required
                    />
                  </div>
                  <div className="mb-3">
                    <label className="form-label">Date de naissance</label>
                    <input
                      type="date"
                      className="form-control"
                      name="birthDate"
                      value={formData.birthDate}
                      onChange={handleInputChange}
                      required
                    />
                  </div>
                  <button type="submit" className="btn btn-primary">Ajouter</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      )}
    </div>
  );
};

export default UserTableau;