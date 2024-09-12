import React, { useEffect, useState } from 'react';
import { useParams } from 'react-router-dom';

const PossessionTableau = () => {
  const { id } = useParams();
  const [possessions, setPossessions] = useState([]);

  useEffect(() => {
    if (id) {
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