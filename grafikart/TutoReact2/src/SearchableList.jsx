import { Fragment, useEffect, useMemo, useState } from "react";

export function SearchableList({ item }) {
    const [search, setSearch] = useState("");
    
    const filteredItems = useMemo(() => {
        return item.filter((item) => item.name.toLowerCase().includes(search.toLowerCase()));
    }, [search, item]);

    const [selectedItemIndex, setSelectedIndex] = useState(0);

    useEffect(() => {
        setSelectedIndex(0);
    }, [filteredItems]);

    const handleKeys = (e) => {
        switch (e.key) {
            case "ArrowDown":
                e.preventDefault();
                setSelectedIndex((v) => (v + 1 + filteredItems.length) % filteredItems.length);
                break;
            case "ArrowUp":
                e.preventDefault();
                setSelectedIndex((v) => (v - 1 + filteredItems.length) % filteredItems.length);
                break;
            default:
                break;
        }
    };

    return (
        <div>
            <input type="text" className="form-control mb-1" placeholder="Rechercher..." value={search}
                onChange={(e) => setSearch(e.target.value)} onKeyDown={handleKeys} />
            <ul className="list-group">
                {filteredItems.map((item, k) => (
                    <Fragment key={item.name}></Fragment>
                ))}
            </ul>
        </div>
    );
}