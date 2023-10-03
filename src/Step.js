import { useState } from 'react';

export const Step = ({
  title,
  options,
  multiSelected,
  selectedOptions,
  handleCheckboxChange
}) => {

  const [selectedOption, setSelectedOption] = useState(null);

  const handleChange = (option) => {
    if (!multiSelected) {

      setSelectedOption(option);
    }
    handleCheckboxChange(option, title, multiSelected);
  };

  return (
    <>
      <div>
        <p className="text-3xl mb-4">{title}</p>
        {multiSelected && (
          <span className="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10 mb-3">
            Выберите один или несколько
          </span>
        )}
        {options.map((option) => (
          <div key={option} className="mb-2 p-3 border border-gray-300 rounded-lg">
            <label className="flex items-center space-x-2">
              <input
                type="checkbox"
                name={option}
                checked={multiSelected ? selectedOptions[title] && selectedOptions[title].includes(option) : selectedOption === option}
                onChange={() => handleChange(option)}
                className="form-checkbox h-5 w-5 text-blue-600"
              />
              <span className="text-gray-700">{option}</span>
            </label>
          </div>
        ))}
      </div>
    </>
  );
};

