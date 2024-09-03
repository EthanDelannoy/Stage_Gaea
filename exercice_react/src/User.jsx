import React from 'react';
import { Link } from 'react-router-dom';
import { calculateAge } from './UserService';

function User({ users }) {
  return (
    <div>
      <h1>Liste des utilisateurs</h1>
      <table className="table table-bordered">
        <thead className="thead-dark">
          <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Email</th>
            <th>Adresse</th>
            <th>Téléphone</th>
            <th>Date de naissance</th>
            <th>Âge</th>
          </tr>
        </thead>
        <tbody>
          {users.map(user => (
            <tr key={user.id}>
              <td>{user.id}</td>
              <td>
                <Link to={`/user/${user.id}`}>{user.nom}</Link>
              </td>
              <td>{user.prenom}</td>
              <td>{user.email}</td>
              <td>{user.adresse}</td>
              <td>{user.tel}</td>
              <td>{user.birthdate}</td>
              <td>{calculateAge(user.birthdate)}</td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
}

export default User;