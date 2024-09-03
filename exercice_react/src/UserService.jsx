function calculateAge(birthdate) {
    if (!birthdate) return '';
  
    const today = new Date(); // Récupère la date actuelle
    const birthDate = new Date(birthdate); // Convertit la date de naissance en objet Date
    let age = today.getFullYear() - birthDate.getFullYear(); // Calcule l'âge de base
  
    // Vérifie si l'anniversaire de cette année est déjà passé ou non
    const monthDifference = today.getMonth() - birthDate.getMonth();
    if (
      monthDifference < 0 ||
      (monthDifference === 0 && today.getDate() < birthDate.getDate())
    ) {
      age--; // Si l'anniversaire n'est pas encore passé cette année, on soustrait un an
    }
  
    return age; // Retourne l'âge calculé
  }
  
  // Exporte la fonction pour pouvoir l'utiliser ailleurs
  export { calculateAge };