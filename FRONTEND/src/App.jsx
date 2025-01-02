import React from 'react';
import { BrowserRouter as Router, Routes, Route } from 'react-router-dom';
import './index.css';
import './style.css';

// pages
import Master from './Master';
import Login from './pages/Login';
import Register from './pages/Register';
import Home from './pages/Home';
import Board from './pages/Board';

function App() {
  return (
    <>
    <Router>
      <Routes>
        <Route path='' element={<Master/>}>
          <Route path='' element={<Login/>}></Route>
          <Route path='/register' element={<Register/>}></Route>
          <Route path='/home' element={<Home/>}></Route>
          <Route path='/board/:id' element={<Board/>}></Route>
        </Route>
      </Routes>
    </Router>
    </>
  );
}

export default App;
