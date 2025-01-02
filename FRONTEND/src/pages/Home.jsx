import React, { useState, useEffect } from 'react';
import { useNavigate, Link } from 'react-router-dom';
import Api from '../Api';
import '../assets/home.css';

const Home = () => {
    const token = localStorage.getItem('token');
    const navigate = useNavigate();

    useEffect(() => {
        if (!token) {
            navigate('/');
        }
    }, [])

    const [boardData, setBoardData] = useState([]);
    const [addBoardData, setAddBoardData] = useState({
        'name': '',
    })
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);

    useEffect(() => {
        const fetchData = async () => {
            try {
                const responses = await Promise.all([
                    Api.get('/v1/board', { params: { token } }),
                ]);

                const [boardResponse] = responses;

                console.log(boardResponse.data.data);
                setBoardData(boardResponse.data.data);
            } catch (error) {
                console.log(error);
                setError('Failed to fetch data.');
            } finally {
                setLoading(false);
            }
        }

        fetchData();
    }, []);

    const handleChange = (e, id) => {
        // setBoardData({
        //     ...boardData, [e.target.name]: e.target.value
        // })
        setBoardData((prevData) =>
            prevData.map((board) =>
                board.id === id ? { ...board, [e.target.name]: e.target.value} : board
            )
        )
    }

    const handleAdd = (e) => {
        setAddBoardData({
            ...addBoardData, [e.target.name]: e.target.value
        })
    }

    const handleUpdate = async (e, id) => {
        e.preventDefault();
        const boardToUpdate = boardData.find((board) => board.id === id);

        try {
            const response = await Api.put(`/v1/board/${id}`, boardToUpdate, { params: { token }});
            alert('updated successfully!')
            console.log('update success: ', response.data)
        }
        catch (err) {
            console.log(err);
        }
    }

    const handleDelete = async (id) => {
        try {
            const response = await Api.delete(`/v1/board/${id}`, { params: { token }})
            alert(`delete success! deleted id board = ${id}`)
            console.log(response)

            setBoardData((prevData) => prevData.filter((board) => board.id !== id));
        }
        catch (error) {
            console.log(error)
        }
    }

    const handleSubmit = async (e) => {
        e.preventDefault();
        try {
            const response = await Api.post(`/v1/board`, addBoardData, { params: { token }})
            console.log(response.data)
            alert('successfully added new board!')

            const reFetch = await Api.get('/v1/board', { params: { token }});
            setBoardData(reFetch.data.data);
        }
        catch (err) {
            console.log(err);
        }
    }

    if (loading) return <div>Loading...</div>
    if (error) return <div>Error: {error}</div>

    return(
        <>
        <div class="container">
            <div class="board-container">
            
            {boardData && boardData.length > 0 ? (
            boardData.map((board) => (
            <>
                <div class="board-wrapper">
                    <div class="board">
                        <form onSubmit={(e) => handleUpdate(e, board.id)}>
                            <p>Board Name: </p>
                            <input type="text"
                            placeholder='Are you sure want to delete?' 
                            name='name'
                            value={board.name}
                            onChange={(e) => handleChange(e, board.id)}/>
                            <input type='submit' value='submit'/>
                        </form>
                        <button onClick={() => handleDelete(board.id)} className='deleteBtn'>Delete</button>
                            <Link to={`/board/${board.id}`}>Details</Link>
                    </div>
                </div>
            </>
            ))
                ) : (
                    <p>no data</p>
                )}
                <div class="board-wrapper">
                    <div class="board new-board">
                        <form onSubmit={handleSubmit}>
                        <input type="text" placeholder="New Board Name"
                        name='name'
                        value={addBoardData.name}
                        onChange={handleAdd}/>
                        <input type="submit" value='Add'/>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        </>
    );
}

export default Home;