import React from 'react';
import renderer from 'react-test-renderer';
import Dashboard from '../views/Dashboard'; 
import User from '../views/UserProfile';
import LogIn from '../views/LogIn';
import Classroom from '../views/Classroom';
import addHW from '../views/addHW';
import addTest from '../views/addTest';

describe("Testing Add Tests", () => {
    it("renders correctly", () => {
        const tree = renderer.create(<addTest/>).toJSON();
        expect(tree).toMatchSnapshot();
    })
})