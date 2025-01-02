import React, { useState, useEffect } from 'react';
import Api from '../Api';
import { useNavigate, NavLink } from 'react-router-dom';
import '../assets/login.css';
import '../style.css';

const Register = () => {
    const token = localStorage.getItem('token');
    const navigate = useNavigate();

    useEffect(() => {
        if (token) {
            navigate('/home');
        }
    }, [])

    const [formData, setFormData] = useState({
        'first_name': '',
        'last_name': '',
        'username': '',
        'password': '',
        'confirm_password': '',
    });

    const handleChange = (e) => {
        setFormData({
            ...formData, [e.target.name]: e.target.value
        })
    }

    const handleSubmit = async (e) => {
        e.preventDefault();

        if (formData.password !== formData.confirm_password) {
            alert('Password did not match!')
            return;
        }

        try {
            const { confirm_password, ...newForm } = formData;
            const response = await Api.post('/v1/auth/register', newForm);

            const { token } = response.data;
            const { username } = response.data;
            localStorage.setItem('token', token);
            localStorage.setItem('username', username)

            navigate('/home');
        }
        catch (err) {
            console.log(err);
        }
    }


    return(
        <>
        <div class="form">
            <header>Register</header>
            <form onSubmit={handleSubmit}>
                
                <input type="text" placeholder="First Name"
                name='first_name'
                value={formData.first_name}
                onChange={handleChange}/>

                <input type="text" placeholder="Last Name"
                name='last_name'
                value={formData.last_name}
                onChange={handleChange}/>

                <input type="text" placeholder="Username"
                name='username'
                value={formData.username}
                onChange={handleChange}/>

                <input type="password" placeholder="Password"
                name='password'
                value={formData.password}
                onChange={handleChange}/>

                <input type="password" placeholder="Confirm Password"
                name='confirm_password'
                value={formData.confirm_password}
                onChange={handleChange}/>

                <input type="submit" value="Register"/>
            </form>
            <p>Already have account? <NavLink to='/' style={{ color: '#248ea9', cursor: 'pointer'}}>Login now!</NavLink></p>
        </div>
        </>
    );
}

export default Register;