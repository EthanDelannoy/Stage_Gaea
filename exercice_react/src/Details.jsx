import React from 'react';
import { useParams } from 'react-router-dom';

function Details({ users }) {
  const { id } = useParams();
  const user = users.find(user => user.id === parseInt(id));

  return (
    <div>
      <h1>Détails de {user.prenom} {user.nom}</h1>
      <p><strong>Email :</strong> {user.email}</p>
      <p><strong>Adresse :</strong> {user.adresse}</p>
      <p><strong>Téléphone :</strong> {user.tel}</p>
      <p><strong>Date de naissance :</strong> {user.birthdate}</p>
      
      <h2>Possessions</h2>
      {user.possessions && user.possessions.length > 0 ? (
        <table className="table table-bordered">
          <thead className="thead-dark">
            <tr>
              <th>Nom</th>
              <th>Type</th>
              <th>Valeur</th>
            </tr>
          </thead>
          <tbody>
            {user.possessions.map((possession, index) => (
              <tr key={index}>
                <td>{possession.nom}</td>
                <td>{possession.type}</td>
                <td>{possession.valeur}</td>
              </tr>
            ))}
          </tbody>
        </table>
      ) : (
        <p>Aucune possession</p>
      )}
    </div>
  );
}

export default Details;