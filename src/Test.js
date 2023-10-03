import { useState, useEffect } from 'react';
import { Step } from './Step'
import { steps } from './options';
import { sendPost } from './sendPost';
import FinalStep from './FinalStep';

const Test = () => {
  const [step, setStep] = useState(1);
  const [isFormSubmitted, setIsFormSubmitted] = useState(false);
  const [isNextDisabled, setIsNextDisabled] = useState(true);

  const [selectedOptionsObject, setSelectedOptionsObject] = useState({
    'Укажите тип вашего долга': [],
    'Общая сумма задолженности ?': [],
    'Ваш трудовой статус ?': [],
    'Потребуется сбор документов ?': [],
    'Ваш официальный доход ?': [],
    'У Вас есть имущество ?': [],
    'Что вас сейчас беспокоит ?': [],
    'Номер телефона': ''
  });

  useEffect(() => {
    setIsNextDisabled(selectedOptionsObject[steps[step - 1]?.title]?.length === 0);
  }, [step, selectedOptionsObject]);

  const totalSteps = steps.length + 1;

  const handleNextStep = () => {
    setStep(step + 1);
  };

  const handlePreviousStep = () => {
    setStep(step - 1);
  };

  const handleCheckboxChange = (option, title, multiSelected) => {
    setSelectedOptionsObject((prevOptions) => {
      if (!multiSelected) {
        return {
          ...prevOptions,
          [title]: [option],
        };
      }

      return {
        ...prevOptions,
        [title]: prevOptions[title].includes(option)
          ? prevOptions[title].filter((item) => item !== option)
          : [...prevOptions[title], option],
      };
    });
  };

  const handlePhoneChange = (e) => {
    const newPhoneValue = e.target.value;
    setSelectedOptionsObject((prevOptions) => ({
      ...prevOptions,
      'Номер телефона': newPhoneValue,
    }));
  };

  const handleSubmit = async () => {
    console.log(selectedOptionsObject)
    await sendPost(selectedOptionsObject)
    setIsFormSubmitted(true);
  };

  const percentComplete = (step / totalSteps) * 100;

  return (
    <>{!isFormSubmitted && (
      <div className="w-10/12 m-4 page">
        {step === totalSteps ? (
          <FinalStep handleSubmit={handleSubmit} handlePhoneChange={handlePhoneChange} selectedOptionsObject={selectedOptionsObject} />
        ) : (
          <div className='flex flex-col justify-between page'>
            <Step
              title={steps[step - 1].title}
              options={steps[step - 1].options}
              multiSelected={steps[step - 1].multiSelected}
              selectedOptions={selectedOptionsObject[steps[step - 1].title] || []}
              handleCheckboxChange={handleCheckboxChange}
              handleSubmit={handleSubmit}
            />
            <div>
              <div className="m-4">
                <div className="pt-1">
                  <div className="flex mb-2 items-center justify-between">
                    <div>
                      <span className="text-xs font-semibold">
                        Готово:
                      </span>
                      <span className="text-xs font-semibold inline-block text-blue-600 ms-3">
                        {percentComplete.toFixed(2)}%
                      </span>
                    </div>
                  </div>
                  <div className="overflow-hidden h-2 mb-4 text-xs flex rounded bg-blue-200">
                    <div style={{ width: `${percentComplete}%` }} className="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-blue-500"></div>
                  </div>

                  <div className='text-right'>
                    {handlePreviousStep && step > 1 && (
                      <button
                        onClick={handlePreviousStep}
                        className="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2 focus:outline-none focus:shadow-outline"
                      >
                        Назад
                      </button>
                    )}
                    <button
                      onClick={handleNextStep}
                      className={`bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline ${isNextDisabled ? 'opacity-50 cursor-not-allowed' : ''
                        }`}
                      disabled={isNextDisabled}
                    >
                      Далее
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        )}
      </div>
    )}
      {isFormSubmitted && (
        <div className="text-3xl text-center mt-10">
          <p>Форма успешно отправлена!</p>
        </div>
      )}
    </>
  );
}

export default Test;
