import React, { useState, useEffect } from 'react';
import '../assets/board.css';

const Board = () => {
    return(
        <>
        <div class="container">
            <div class="team-container">
                <div class="board-name">Board Name</div>
                <div class="member" title="John Doe">JD</div>
                <div class="member" title="Richard Roe">RR</div>
                <div class="member" title="Jane Poe">JP</div>
                <a href="" class="button">+ Add member</a>
            </div>
            <div class="card-container">
                <div class="content">
                    <div class="list">
                        <header>Backlog</header>
                        <div class="cards">
                            <div class="card">
                                <div class="card-content">
                                    Manage User
                                </div>
                                <div class="control">
                                    <span>&uarr;</span>
                                    <span>&darr;</span>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-content">
                                    Manage Role
                                </div>
                                <div class="control">
                                    <span>&uarr;</span>
                                    <span>&darr;</span>
                                </div>
                            </div>
                        </div>
                        <div class="button">+ Add new card</div>
                        <div class="control">
                            <span>&larr;</span>
                            <span>&rarr;</span>
                        </div>
                    </div>
                    <div class="list">
                        <header>On Progress</header>
                        <div class="cards">
                            <div class="card">
                                <div class="card-content">
                                    Create homepage
                                </div>
                                <div class="control">
                                    <span>&uarr;</span>
                                    <span>&darr;</span>
                                </div>
                            </div>
                        </div>
                        <div class="button">+ Add new card</div>
                        <div class="control">
                            <span>&larr;</span>
                            <span>&rarr;</span>
                        </div>
                    </div>
                    <div class="list">
                        <header>Review</header>
                        <div class="cards">
                        </div>
                        <div class="button">+ Add new card</div>
                        <div class="control">
                            <span>&larr;</span>
                            <span>&rarr;</span>
                        </div>
                    </div>
                    <div class="list">
                        <header>Done</header>
                        <div class="cards">
                        </div>
                        <div class="button">+ Add new card</div>
                        <div class="control">
                            <span>&larr;</span>
                            <span>&rarr;</span>
                        </div>
                    </div>
                    <div class="list button">
                        <span>+ Add another list</span>
                    </div>
                </div>
            </div>
        </div>
        </>
    );
}

export default Board;