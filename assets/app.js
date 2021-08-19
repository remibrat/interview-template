/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

import React from 'react';
import ReactDOM from 'react-dom';

// start the Stimulus application
import './bootstrap';
// any CSS you import will output into a single css file (app.css in this case)
import './styles/global.scss';
import './styles/app.css';
require('bootstrap');


const Component = ({ name }) => <h1>
  Hello {name} with React
</h1>;
const root = document.getElementById('react-root');
ReactDOM.render(React.createElement(Component, JSON.parse(root.dataset.props)), root);
