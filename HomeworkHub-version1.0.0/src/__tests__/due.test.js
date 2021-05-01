import React from 'react';
import renderer from 'react-test-renderer';
import Dashboard from '../views/Dashboard'; 
import User from '../views/UserProfile';
import LogIn from '../views/LogIn';
import Classroom from '../views/Classroom';
import addHW from '../views/addHW';
import addTest from '../views/addTest';
import addDue from '../views/addDue'


describe("Testing Add due", () => {
    it("renders correctly", () => {
        const tree = renderer.create(<addDue/>).toJSON();
        expect(tree).toMatchSnapshot();
    })
})