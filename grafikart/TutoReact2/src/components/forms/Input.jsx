import { forwardRef, useId } from "react"

/**
 * @param {string} placeholder
 * @param {string} value
 * @param {(s: string) => void} onChange
 */

export const Input = forwardRef(function Input ({placeholder, value, onChange, label}, ref){
    const id = useId()
    return <div>
        <label className="form-label" htmlFor={id}>{label}</label>
        <input type="text"
        ref={ref}
        id={id}
         className="form-control"
          value={value}
           placeholder={placeholder}
            onChange={(e) => onChange(e.target.value)} />
        </div>
})