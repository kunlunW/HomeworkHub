import React from 'react';
import renderer from 'react-test-renderer';
import Dashboard from '../views/Dashboard'; 
import User from '../views/UserProfile';
import LogIn from '../views/LogIn';
import Classroom from '../views/Classroom';
import addHW from '../views/addHW';
import addTest from '../views/addTest';


describe("Testing Add Homework", () => {
    it("renders correctly", () => {
        const tree = renderer.create(<addHW/>).toJSON();
        expect(tree).toMatchSnapshot();
    })
});



