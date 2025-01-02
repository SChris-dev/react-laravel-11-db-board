import React, { useState, useEffect } from 'react';
import Api from '../Api';
import { useNavigate, NavLink } from 'react-router-dom';
import '../assets/login.css';
import '../style.css';

const Login = () => {
    const [loginData, setLoginData] = useState({
        'username': '',
        'password': '',
    })
    const token = localStorage.getItem('token');
    const navigate = useNavigate();

    useEffect(() => {
        if (token) {
            navigate('/home');
        }
    }, []);

    const handleChange = (e) => {
        setLoginData({
            ...loginData, [e.target.name]: e.target.value
        })
    }


    const handleSubmit = async (e) => {
        e.preventDefault();
        try {
            const response = await Api.post('/v1/auth/login', loginData);
            localStorage.setItem('token', response.data.token);
            localStorage.setItem('username', response.data.username);
            navigate('/home');
        }
        catch (err) {
            console.log(err);
        }
    }

    return(
        <>
        <div class="form">
            <header>Login</header>
            <form onSubmit={handleSubmit}>
                <input type="text" placeholder="Username"
                name='username'
                value={loginData.username}
                onChange={handleChange}/>
                <input type="password" placeholder="Password"
                name='password'
                value={loginData.password}
                onChange={handleChange}/>
                <input type="submit" value="Login"/>
            </form>
            <p>Don't have account? <NavLink to='/register' style={{color: '#248ea9', cursor: 'pointer'}}>Register now!</NavLink></p>
        </div>
        </>
    );
}

export default Login;