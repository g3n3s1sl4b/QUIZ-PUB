import Test from './Test';

const TestPage = () => {
  return (
    <div className="flex h-screen w-screen">
      <div className="w-full md:w-11/12 flex flex-col items-center">
        <p className='m-5 text-base'>Узнайте, спишутся ли ваши долги по 127-ФЗ</p>
        <hr className="border-solid w-full" />
        <Test />
      </div>
      <div class="hidden md:block bg-gray-100 w-80 h-screen">
        <img src="./bonuses2.png" alt="bonuses" class="w-30 mt-3"/>
      </div>

    </div>
  );
}

export default TestPage;


