import React from 'react';
import renderer from 'react-test-renderer';
import Dashboard from '../views/Dashboard'; 
import User from '../views/UserProfile';
import LogIn from '../views/LogIn';
import addHW from '../views/addHW';
import addTest from '../views/addTest';
import addDue from '../views/addDue';
import addAnnouncement from '../views/addAnnouncement';
import Classroom from '../views/Classroom';
import ParentClassroom from '../views/ParentClassroom';
import ParentCalendar from '../views/ParentCalendar';
import App from '../views/components_calendar_parent/App'
import viewStudent from '../views/viewStudent';


describe("Testing view students", () => {
    it("renders correctly", () => {
        const tree = renderer.create(<viewStudent/>).toJSON();
        expect(tree).toMatchSnapshot();
    })
})
