import { Form, Button } from "react-bootstrap"

import {EmployeeContext} from '../contexts_test/EmployeeContext';
import {useContext, useState} from 'react';

const AddForm = (props) =>{
    
    const [newEmployee, setNewEmployee] = useState({
        id:"", name:"", date:"", limit:"", points:"", desc: ""
    });

    const onInputChange = (e) => {
        setNewEmployee({...newEmployee,[e.target.name]: e.target.value})
    }

    const {id, name, date, limit, points, desc} = newEmployee;

    const handleSubmit = (e) => {
        e.preventDefault();
        props.addTest(id, name, date, limit, points, desc);
    }

     return (

        <Form onSubmit={handleSubmit} >
            <Form.Group>
                <Form.Control
                    type="text"
                    placeholder="Classrom ID *"
                    name="id"
                    value={id}
                    onChange = { (e) => onInputChange(e)}
                    // required
                />
            </Form.Group>
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
                    as="textarea"
                    rows="3"
                    placeholder="Description *"
                    name="desc"
                    value={desc}
                    onChange = { (e) => onInputChange(e)}
                    // required
                />
            </Form.Group>
            <Form.Group>
                <Form.Control
                    type="text"
                    placeholder="Test Date *"
                    name="date"
                    value={date}
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