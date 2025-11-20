import { SVGAttributes } from 'react';

export default function AppLogoIcon(props: SVGAttributes<SVGElement>) {
    return (
        <svg {...props} viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" strokeWidth="1.8" strokeLinecap="round" strokeLinejoin="round">
            {/* Tenedor (izquierda, cruzado) */}
            <g transform="rotate(-45 12 12)">
                <line x1="8" y1="4" x2="8" y2="20" />
                <line x1="8" y1="4" x2="8" y2="9" />
                <line x1="6" y1="4" x2="6" y2="9" />
                <line x1="10" y1="4" x2="10" y2="9" />
            </g>
            
            {/* Cuchillo (derecha, cruzado) */}
            <g transform="rotate(45 12 12)">
                <line x1="16" y1="4" x2="16" y2="20" />
                <path d="M14 4 L18 4 L18 7 L14 7 Z" fill="currentColor" />
            </g>
        </svg>
    );
}
