import React, { useState } from 'react';
import ReactDOM from "react-dom";
import { Formik, Form, Field } from "formik";
import * as Yup from "yup";

const FIELDS = [
    { name: 'name', label: "NAME", required: true, type: "text", placeholder: "Luke Skywalker" },
    { name: "height", label: "HEIGHT", required: true, type: "number", placeholder: "172" },
    { name: "mass", label: "MASS", required: true, type: "number", placeholder: "73" },
    { name: "hair_colour", label: "HAIR COLOUR", required: true, type: 'text', placeholder: "Blonde" },
    { name: "birth_year", label: "BIRTH YEAR", required: true, type: 'text', placeholder: "19BBY" },
    { name: "gender", label: "GENDER", required: true, type: 'text', placeholder: "Male" },
    { name: "homeworld", label: "HOMEWORLD NAME", required: true, type: 'text', placeholder: "Tatooine" },
    { name: "species", label: "SPECIES NAME", required: true, type: 'text', placeholder: "Human" }
];

const FORMIK_INITIAL_VALUES = {
    name: '',
    height: '',
    mass: '',
    hair_colour: '',
    birth_year: '',
    gender: '',
    homeworld: '',
    species: ''
};

const VALIDATION_SCHEMA = Yup.object().shape({
    name: Yup.string().required("Required."),
    height: Yup.number().required("Required.").min(0, "Height has to be greater than or equal to zero"),
    mass: Yup.string().required("Required.").min(0, "Mass has to be greater than or equal to zero"),
    hair_colour: Yup.string().required("Required."),
    birth_year: Yup.string().required("Required.").test('valid-birth-year', 'Invalid birth year. Must be in BBY or ABY format.', (value) => {
        if (!window._.isString(value)){
            return false;
        }
        if (!value.includes("BBY") && !value.includes("ABY")) {
            return false;
        }
        const justNumericYear = value.includes("BBY") ? value.replace("BBY", "") : value.replace("ABY", "");
        return window._.isFinite(parseInt(justNumericYear, 10));
    }),
    gender: Yup.string().required("Required."),
    homeworld: Yup.string().required("Required."),
    species: Yup.string().required("Required.")
});


function CreateCharacter() {
    //Set states using hooks
    const [successMessage, setSuccessMessage] = useState('');
    const [errorMessages, setErrorMessages] = useState([]);
    const [showAlert, setShowAlert] = useState(false);
    const [showWhich, setShowWhich] = useState('');

    const onSubmitFunction = (values, { setSubmitting, resetForm }) => {
        // console.log(values);

        //Get CSRF TOKEN
        let csrfToken = '';
        const metas = document.getElementsByTagName('meta');
        for (let i = 0; i < metas.length; i++) {
            if (metas[i].getAttribute('name') === "csrf-token") {
                csrfToken = metas[i].getAttribute('content');
                break;
            }
        }
        // console.log(csrfToken);

        window.axios
            .post('/create_character_submit', values, { headers: { 'X-CSRF-TOKEN': csrfToken } })
            .then(response => {
                // console.log(response);
                if (response.data.success) {
                    setShowAlert(true);
                    setShowWhich('alert-success');
                    setSuccessMessage(response.data.messages[0]);
                    resetForm();
                } else {
                    setShowAlert(true);
                    setShowWhich('alert-danger')
                    setErrorMessages(response.data.messages);
                }
                setSubmitting(false);
            })
            .catch(error => {
                console.log("error ", error);
                setShowAlert(true);
                setShowWhich('alert-danger')
                setErrorMessages(error.data.message);
            })
    }

    const alertClassName = `alert ${showWhich} alert-dismissible fade show`;
    const alertMessages = showWhich === 'alert-success'
        ? [successMessage]
        : errorMessages;

    return (
        <div className="container-fluid">
            <Formik initialValues={FORMIK_INITIAL_VALUES} onSubmit={onSubmitFunction} validationSchema={VALIDATION_SCHEMA}>
                {({ isSubmitting, errors, touched }) => (
                    <Form>
                        {FIELDS.map(
                            (
                                { name, required, type, label, placeholder },
                                index
                            ) => (
                                <div className="form-group pt-3 pl-2" key={index}>
                                    <label htmlFor={name}>{label}</label>
                                    <Field
                                        id={name}
                                        name={name}
                                        required={required}
                                        type={type}
                                        className="form-control form-control-lg"
                                        aria-label={label}
                                        aria-describedby={`LABEL-${name}`}
                                        placeholder={placeholder}
                                    />
                                    <div className="invalid-field-southern">
                                        {errors[name] && touched[name] && errors[name]}
                                    </div>
                                </div>
                            )
                        )}
                        {showAlert && (
                            <div className={alertClassName} role="alert">
                                {Array.isArray(alertMessages) && alertMessages.map((alertMessage, alertIndex) => (
                                    <React.Fragment key={`ALERT-${alertIndex}`}>
                                        {alertMessage}<br />
                                    </React.Fragment>
                                ))}
                                <button type="button" className="close" data-dismiss="alert" aria-label="Close" onClick={() => setShowAlert(false)}>
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        )}
                        <div className="pt-3 pl-2">
                            <button type="submit" disabled={isSubmitting} className="btn btn-primary">Submit</button>
                        </div>
                    </Form>
                )}
            </Formik>
        </div>
    );
}

export default CreateCharacter;

if (document.getElementById('create-character')) {
    ReactDOM.render(<CreateCharacter />, document.getElementById('create-character'));
}
