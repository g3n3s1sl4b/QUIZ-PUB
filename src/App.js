import { BrowserRouter as Router, Route, Routes } from 'react-router-dom';
import 'tailwindcss/tailwind.css';
import StartTest from './StartTest';
import TestPage from './TestPage';

function App() {
  return (
    <Router>
      <Routes>
        <Route path="/" element={<StartTest />} />
        <Route path="/test" element={<TestPage />} />
      </Routes>
    </Router>
  );
}

export default App;

