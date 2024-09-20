import React, { useEffect, useState } from 'react';
import { useParams } from 'react-router-dom';

const PossessionTableau = () => {
  const { id } = useParams();
  const [possessions, setPossessions] = useState([]);
  const [userInfo, setUserInfo] = useState(null);

  useEffect(() => {
    if (id) {
      fetch(`/api/users/${id}`)
        .then(response => {
          if (!response.ok) {
            throw new Error('Erreur lors de la récupération des informations de l\'utilisateur');
          }
          return response.json();
        })
        .then(data => {
          setUserInfo(data);
        })
        .catch(error => console.error('Error fetching user info:', error));

      fetch(`/api/users/${id}/possessions`)
        .then(response => {
          if (!response.ok) {
            throw new Error('Erreur lors de la récupération des possessions');
          }
          return response.json();
        })
        .then(data => {
          setPossessions(data);
        })
        .catch(error => console.error('Error fetching user possessions:', error));
    }
  }, [id]);

  return (
    <div className='container mt-5'>
      <h2 className="text-center">Informations de l'utilisateur</h2>
      <table className="table table-striped table-bordered">
        <thead>
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
          {userInfo && (
            <tr>
              <td>{userInfo.id}</td>
              <td>{userInfo.nom}</td>
              <td>{userInfo.prenom}</td>
              <td>{userInfo.email}</td>
              <td>{userInfo.adresse}</td>
              <td>{userInfo.tel}</td>
              <td>{userInfo.birthDate}</td>
              <td>{userInfo.age}</td>
            </tr>
          )}
        </tbody>
      </table>

      <h2 className="text-center">Possessions de l'utilisateur</h2>
      <table className="table table-striped table-bordered">
        <thead>
          <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Valeur</th>
            <th>Type</th>
          </tr>
        </thead>
        <tbody>
          {possessions.length === 0 ? (
            <tr>
              <td colSpan="4">Aucune possession trouvée.</td>
            </tr>
          ) : (
            possessions.map(possession => (
              <tr key={possession.id}>
                <td>{possession.id}</td>
                <td>{possession.nom}</td>
                <td>{possession.valeur}</td>
                <td>{possession.type}</td>
              </tr>
            ))
          )}
        </tbody>
      </table>
    </div>
  );
};

export default PossessionTableau;