import { Form, Button } from "react-bootstrap"

import {EmployeeContext} from '../contexts_due/EmployeeContext';
import {useContext, useState} from 'react';

const AddForm = (props) =>{

    const [newEmployee, setNewEmployee] = useState({
        id: "", name:"", desc:"", date:"", points:""
    });

    const onInputChange = (e) => {
        setNewEmployee({...newEmployee,[e.target.name]: e.target.value})
    }

    const {id, name, desc, date, points} = newEmployee;

    const handleSubmit = (e) => {
        e.preventDefault();
        props.addHomework(id, name, desc, date, points);
    }

     return (

        <Form onSubmit={handleSubmit}>
            <Form.Group>
                <Form.Control
                    type="text"
                    placeholder="Classroom ID *"
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
                    type="text"
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
                    placeholder="Due Date *"
                    name="date"
                    value={date}
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
            <Button variant="success" type="submit" block>
                Add New Homework
            </Button>
        </Form>

     )
}

export default AddForm;