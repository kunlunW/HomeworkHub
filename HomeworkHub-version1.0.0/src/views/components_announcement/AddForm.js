import { Form, Button } from "react-bootstrap"

import {EmployeeContext} from '../contexts_test/EmployeeContext';
import {useContext, useState} from 'react';

const AddForm = (props) =>{
    
    const [newEmployee, setNewEmployee] = useState({
        id:"", name:"", desc: "", date:""
    });

    const onInputChange = (e) => {
        setNewEmployee({...newEmployee,[e.target.name]: e.target.value})
    }

    const {id, name, desc, date} = newEmployee;

    const handleSubmit = (e) => {
        e.preventDefault();
        props.addAnnouncement(id, name, desc, date);
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
                    placeholder="Announcement *"
                    name="desc"
                    value={desc}
                    onChange = { (e) => onInputChange(e)}
                    // required
                />
            </Form.Group>
            <Button variant="success" type = "submit">
                Add New Announcement
            </Button>
        </Form>

     )
}

export default AddForm;