import React, { useState } from 'react';
import { useNavigate, useLocation } from 'react-router-dom';
import '../assets/header.css';

const Navbar = () => {
    const navigate = useNavigate();
    const location = useLocation();
    const username = localStorage.getItem('username');

    const handleLogout = () => {
        localStorage.removeItem('token');
        localStorage.removeItem('username');
        alert('Logout success!');
        navigate('/');
    }

    return(
        <>
        <div className="header">
            <div>
                <a href="/home">Papan</a>
            </div>
        {(location.pathname === '/' || location.pathname === '/register') ? (
            <div></div>
        ) : (
            <div className='right'>
                <a>{username}</a>
                <a onClick={handleLogout}>Logout</a>
            </div>
        )}
        </div>
        </>
    );
}

export default Navbar;