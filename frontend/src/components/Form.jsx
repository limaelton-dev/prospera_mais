import React, { useState } from 'react';

const Form = ({ onSubmit }) => {
  const [formData, setFormData] = useState({
    username: '',
    email: '',
  });

  const handleChange = (e) => {
    setFormData({ ...formData, [e.target.name]: e.target.value });
  };

  const handleSubmit = (e) => {
    e.preventDefault();
    onSubmit(formData);
  };

  return (
    <form onSubmit={handleSubmit}>
      <label>
        Username:
        <input type="text" name="username" value={formData.username} onChange={handleChange} />
      </label>
      <br />
      <label>
        Email:
        <input type="text" name="email" value={formData.email} onChange={handleChange} />
      </label>
      <br />
      <button type="submit">Submit</button>
    </form>
  );
};

export default Form;