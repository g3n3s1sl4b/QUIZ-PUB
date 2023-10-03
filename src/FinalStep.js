import { useState } from 'react';

const FinalStep = ({ handleSubmit, handlePhoneChange, selectedOptionsObject }) => {
  const [selectedOption, setSelectedOption] = useState(null);

  const handleOptionSelect = (option) => {
    setSelectedOption(option);
  };

  const handleFormSubmit = () => {
    handleSubmit(selectedOption);
  };

  return (
    <div className="flex items-center justify-center">
      <div className="p-4 rounded-md flex flex-col items-center">
        <h2 className="text-2xl font-semibold mb-4 text-gray-700">Для вас есть 2 решения!</h2>
        {!selectedOption && (
          <>
            <p className="text-gray-500 w-90">Выберите, каким способом вы хотели бы получить инструкцию по решению проблем с долгами:</p>
            <div className="grid grid-cols-2 gap-2 my-5 final-icons">
              <div
                className={`cursor-pointer p-3 border border-gray-300 rounded-lg flex ${selectedOption === 'whatsapp' ? 'bg-blue-100' : ''
                  }`}
                onClick={() => handleOptionSelect('whatsapp')}
              >
                <img src="https://cdn.mrqz.me/img/soc-whatsapp.5d8f2f0e.svg" alt='whatsapp' className='w-5 mr-3' />
                WhatsApp
              </div>
              <div
                className={`cursor-pointer p-3 border border-gray-300 rounded-lg flex ${selectedOption === 'phone' ? 'bg-blue-100' : ''
                  }`}
                onClick={() => handleOptionSelect('phone')}
              >
                <img src="https://cdn.mrqz.me/img/soc-phone.885f47d4.svg" alt='телефон' className='w-5 mr-3' />
                По телефону
              </div>
              <div
                className={`cursor-pointer p-3 border border-gray-300 rounded-lg flex ${selectedOption === 'telegram' ? 'bg-blue-100' : ''
                  }`}
                onClick={() => handleOptionSelect('telegram')}
              >
                <img src="https://cdn.mrqz.me/img/soc-telegram.7c773d66.svg" alt='Telegram' className='w-5 mr-3' />
                Telegram
              </div>
              <div
                className={`cursor-pointer p-3 border border-gray-300 rounded-lg flex ${selectedOption === 'viber' ? 'bg-blue-100' : ''
                  }`}
                onClick={() => handleOptionSelect('viber')}
              >
                <img src="https://cdn.mrqz.me/img/soc-viber.ee66d8f3.svg" alt='Viber' className='w-5 mr-3' />
                Viber
              </div>
            </div>

          </>
        )}
        {selectedOption && (
          <div className="mb-4 mt-5">
            <label className="block text-gray-700 text-sm font-bold mb-2">
              Введите номер телефона:
            </label>
            <input
              className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
              type="tel"
              placeholder="+7(999)999-99-99"
              onChange={handlePhoneChange}
            />
          </div>
        )}

        <button
          className="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
          onClick={handleFormSubmit}
          disabled={!selectedOptionsObject['Номер телефона']}
        >
          Получить решение
        </button>

      </div>
    </div>
  );
}

export default FinalStep;
