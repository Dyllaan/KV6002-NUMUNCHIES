'use client'

import React, { useState } from 'react';

interface NutritionFormProps {
  onSubmit: (data: NutritionData) => void;
}

interface NutritionData {
  name: string;
  calories: number;
  protein: number;
  carbohydrates: number;
  fat: number;
}

const NutritionForm: React.FC<NutritionFormProps> = ({ onSubmit }) => {
  const [formData, setFormData] = useState<NutritionData>({
    name: '',
    calories: 0,
    protein: 0,
    carbohydrates: 0,
    fat: 0
  });

  const handleChange = (event: React.ChangeEvent<HTMLInputElement>) => {
    const { name, value } = event.target;
    setFormData({
      ...formData,
      [name]: name === 'name' ? value : parseFloat(value)
    });
  };

  const handleSubmit = (event: React.FormEvent<HTMLFormElement>) => {
    event.preventDefault();
    onSubmit(formData);
    // Reset form after submission
    setFormData({
      name: '',
      calories: 0,
      protein: 0,
      carbohydrates: 0,
      fat: 0
    });
  };

  return (
    <form onSubmit={handleSubmit}>
      <label htmlFor="name">Name:</label>
      <input type="text" id="name" name="name" value={formData.name} onChange={handleChange} required />
      
      <label htmlFor="calories">Calories:</label>
      <input type="number" id="calories" name="calories" value={formData.calories.toString()} onChange={handleChange} required />
      
      <label htmlFor="protein">Protein (g):</label>
      <input type="number" id="protein" name="protein" value={formData.protein.toString()} onChange={handleChange} required />
      
      <label htmlFor="carbohydrates">Carbohydrates (g):</label>
      <input type="number" id="carbohydrates" name="carbohydrates" value={formData.carbohydrates.toString()} onChange={handleChange} required />
      
      <label htmlFor="fat">Fat (g):</label>
      <input type="number" id="fat" name="fat" value={formData.fat.toString()} onChange={handleChange} required />
      
      <button type="submit">Submit</button>
    </form>
  );
};

export default NutritionForm;
