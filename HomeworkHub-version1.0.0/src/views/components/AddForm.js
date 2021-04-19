import { Form, Button } from "react-bootstrap"

import {EmployeeContext} from '../contexts/EmployeeContext';
import {useContext, useState} from 'react';

const AddForm = () =>{

    const [newEmployee, setNewEmployee] = useState({
        id: "", name:"", email:"", mobile_no:"", school:""
    });

    const onInputChange = (e) => {
        setNewEmployee({...newEmployee,[e.target.name]: e.target.value})
    }

    const {id, name, email, mobile_no, school} = newEmployee;

    const handleSubmit = (e) => {
        e.preventDefault();
        props.addParent(id, name, email, mobile_no, school);
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
                    required
                />
            </Form.Group>
            <Form.Group>
                <Form.Control
                    type="text"
                    placeholder="Name *"
                    name="name"
                    value={name}
                    onChange = { (e) => onInputChange(e)}
                    required
                />
            </Form.Group>
            <Form.Group>
                <Form.Control
                    type="email"
                    placeholder="Email *"
                    name="email"
                    value={email}
                    onChange = { (e) => onInputChange(e)}
                    required
                />
            </Form.Group>
            <Form.Group>
                <Form.Control
                    type="text"
                    placeholder="Mobile No"
                    name="mobile_no"
                    value={mobile_no}
                    onChange = { (e) => onInputChange(e)}
                />
            </Form.Group>
            <Form.Group>
                <Form.Control
                    type="text"
                    placeholder="School"
                    name="school"
                    value={school}
                    onChange = { (e) => onInputChange(e)}
                />
            </Form.Group>
            <Button variant="success" type="submit" block>
                Add New Student/Parent
            </Button>
        </Form>

     )
}

export default AddForm;