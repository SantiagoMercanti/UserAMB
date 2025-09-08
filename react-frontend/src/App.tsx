import { BrowserRouter, Routes, Route, NavLink } from 'react-router-dom';
import UsersPage from './pages/UsersPage';
import './styles/app.css';

export default function App() {
  return (
    <BrowserRouter>
      <nav style={{ display: 'flex', gap: 12, padding: 12, borderBottom: '1px solid #ddd' }}>
        <NavLink to="/">Usuarios</NavLink>
      </nav>
      <Routes>
        <Route path="/" element={<UsersPage />} />
      </Routes>
    </BrowserRouter>
  );
}