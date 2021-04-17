import { Form, Button } from "react-bootstrap"

import {EmployeeContext} from '../contexts_test/EmployeeContext';
import {useContext, useState} from 'react';

const AddForm = (props) =>{
    
    const [newEmployee, setNewEmployee] = useState({
        name:"", time:"", limit:"", points:""
    });

    const onInputChange = (e) => {
        setNewEmployee({...newEmployee,[e.target.name]: e.target.value})
    }

    const {name, time, limit, points} = newEmployee;

    const handleSubmit = (e) => {
        e.preventDefault();
        props.addTest(name, time, limit, points);
    }

     return (

        <Form onSubmit={handleSubmit} >
            <Form.Group>
                <Form.Control
                    type="text"
                    placeholder="Name *"
                    name="name"
                    value={name}
                    onChange = { (e) => onInputChange(e)}
                    // required
                />
            </Form.Group>
            <Form.Group>
                <Form.Control
                    type="text"
                    placeholder="Due Time *"
                    name="time"
                    value={time}
                    onChange = { (e) => onInputChange(e)}
                    // required
                />
            </Form.Group>
            <Form.Group>
                <Form.Control
                    type="text"
                    placeholder="Time Limit *"
                    name="limit"
                    value={limit}
                    onChange = { (e) => onInputChange(e)}
                    // required
                />
            </Form.Group>
            <Form.Group>
                <Form.Control
                    type="text"
                    placeholder="Total Points *"
                    name="points"
                    value={points}
                    onChange = { (e) => onInputChange(e)}
                    // required
                />
            </Form.Group>
            <Button variant="success" type = "submit">
                Add New Tests
            </Button>
        </Form>

     )
}

export default AddForm;