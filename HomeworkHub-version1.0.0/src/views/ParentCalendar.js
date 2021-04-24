import React from "react";

import {
  Badge,
  Button,
  Card,
  Navbar,
  Nav,
  Table,
  Container,
  Row,
  Col,
  Dropdown,
  Pagination
} from "react-bootstrap";

import EmployeeList from './components_test/EmployeeList';
import EmployeeContextProvider from './contexts_test/EmployeeContext';
import "./App.css";
import App from './components_calendar_parent/App';

function ParentCalendar() {
  return (
    <div className="container-xl">
      
          {/* <EmployeeContextProvider>
            <EmployeeList />
          </EmployeeContextProvider> */}
          <App />
        </div>
     

  );
}

export default ParentCalendar;

