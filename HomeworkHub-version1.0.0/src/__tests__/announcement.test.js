import React from 'react';
import renderer from 'react-test-renderer';
import Dashboard from '../views/Dashboard'; 
import User from '../views/UserProfile';
import LogIn from '../views/LogIn';
import Classroom from '../views/Classroom';
import addHW from '../views/addHW';
import addTest from '../views/addTest';
import addDue from '../views/addDue';
import addAnnouncement from '../views/addAnnouncement';

describe("Testing Add Announcement", () => {
    it("renders correctly", () => {
        const tree = renderer.create(<addAnnouncement/>).toJSON();
        expect(tree).toMatchSnapshot();
    })
})