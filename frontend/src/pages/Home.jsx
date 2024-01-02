import React from 'react';
import Navbar from '../components/Navbar';
import Button from '../components/Button';
import Form from '../components/Form';

const Home = () => {
  const handleButtonClick = () => {
    alert('Botão clicado!');
  };

  const handleFormSubmit = (formData) => {
    console.log('Formulário enviado:', formData);
  };

  return (
    <div>
      <Navbar />
      <h1>Bem-vindo à Página Principal</h1>
      <Button label="Clique-me" onClick={handleButtonClick} />
      <Form onSubmit={handleFormSubmit} />
    </div>
  );
};

export default Home;