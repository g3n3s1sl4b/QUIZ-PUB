import { useNavigate } from 'react-router-dom';

const StartTest = () => {
  const navigate = useNavigate();

  const start = () => {
    navigate('/test');
  };

  const leftDivStyle = {
    backgroundImage: 'url(https://cdn.media.marquiz.ru/v1/image/upload/vHu1eRMPju7Q6C7jW9muxP.jpg)',
    backgroundSize: 'cover',
    backgroundPosition: 'center',
  }

  return (
    <div className="flex h-screen">
      <div className="w-2/3 hidden md:block" style={leftDivStyle}>
      </div>
      <div className="flex flex-col justify-between ">
        <div className="mt-4">
          <div className="flex ms-5 items-center">
            <img src="https://cdn.media.marquiz.ru/v1/image/upload/6UjXvRqSGCXfjV59UowVeb.png" alt="Логотип" className="mb-4 max-h-9" />
            <h1 className="ms-6 mb-3 text-sm text-gray-700">ФЕДЕРАЛЬНАЯ ПРОГРАММА ПОМОЩИ ДОЛЖНИКАМ</h1>
          </div>
          <hr className="border-solid w-full" />
        </div>
        <div className="ms-5">
          <p className="text-3xl font-medium mb-3 text-gray-800">ПОЛНОСТЬЮ ИЗБАВЬТЕСЬ ОТ ДОЛГОВ ПО КРЕДИТАМ И ЗАЙМАМ</p>
          <p className="text-m text-gray-500 font-medium mb-3">Узнайте, как избавиться от долгов в банках и МФО, звонков коллекторов и приставов на законных основаниях</p>
          <button
            className="bg-blue-700 hover:bg-blue-800 text-white font-bold py-4 px-6 rounded-lg focus:outline-none focus:shadow-outline"
            onClick={start}
          >
            Начать тест
          </button>

          <div className="mt-5">
            <p className="uppercase text-xs">Ваши бонусы после теста</p>
            <div className="flex">
              <img src="./bonuses.png" alt="бонусы" className="mb-4 max-h-24" />
            </div>
          </div>
        </div>
        <div className="ms-5 flex flex-col">
          <p> +7 (909) 77-99-003</p>
          <span className="text-xs text-gray-500"> ООО "ЮК Правое дело", ИНН: 6164108501, ОГРН: 116619607</span>
        </div>
      </div>
    </div>
  );
}

export default StartTest;
