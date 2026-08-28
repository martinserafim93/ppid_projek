---
name: PPID Kaltara
description: Sistem Layanan PPID Provinsi Kalimantan Utara
colors:
  primary: "#1B5E20"
  primary-hover: "#2E7D32"
  primary-active: "#0D3B13"
  accent: "#C9A84C"
  background: "#f4f6f9"
  surface: "#ffffff"
  text-primary: "#333333"
  text-muted: "#666666"
typography:
  body:
    fontFamily: "'Inter', 'Segoe UI', Roboto, Helvetica, Arial, sans-serif"
rounded:
  base: "8px"
  lg: "12px"
spacing:
  base: "16px"
  lg: "24px"
components:
  card:
    backgroundColor: "{colors.surface}"
    rounded: "{rounded.lg}"
    padding: "{spacing.lg}"
---

# Design System: PPID Kaltara

## Overview

**Creative North Star: "Professional and Clean Government Service"**

The PPID Kaltara design system reflects the identity of the Ministry of Religious Affairs (Kemenag) Regional Office of North Kalimantan. It prioritizes clarity, trust, and ease of use for both administrators and public users. The interface uses a clean, structured layout with a strong green primary color symbolizing the institution, accented with a subtle gold/yellow.

**Key Characteristics:**
- Professional and trustworthy
- High contrast and readable
- Clean layout with ample spacing
- Clear visual hierarchy

## Colors

The color palette is derived from the institutional identity of Kemenag, utilizing deep greens and gold accents.

### Primary
- **Institution Green** (#1B5E20): Used for the main sidebar, active states, and primary actions. It represents the core identity.
- **Institution Green Hover** (#2E7D32): Used for hover states on primary elements.
- **Institution Green Active** (#0D3B13): Used for active states and deep backgrounds in the sidebar.

### Secondary
- **Gold Accent** (#C9A84C): Used sparingly for active menu indicators and key highlights to draw attention without overwhelming.

### Neutral
- **Background** (#f4f6f9): A soft, cool gray used as the main app background to make surface elements pop.
- **Surface** (#ffffff): Pure white used for cards, headers, and content areas.
- **Text Primary** (#333333): Used for primary headings and body text for optimal readability.
- **Text Muted** (#666666): Used for secondary text, breadcrumbs, and minor UI elements.

## Typography

**Body Font:** Inter (with Segoe UI, Roboto fallback)

**Character:** Clean, highly legible geometric sans-serif that works well for both data-dense admin interfaces and long-form public content.

## Layout

The layout follows a classic sidebar-header-content pattern for the admin dashboard.
- **Sidebar Width:** 260px (collapsible on mobile)
- **Header Height:** 60px
- **Spacing Rhythm:** Based on a 16px (`spacing-base`) and 24px (`spacing-lg`) scale.

## Elevation & Depth

The system uses subtle shadows to define hierarchy and lift interactive elements off the background.

### Shadow Vocabulary
- **Small Shadow** (`0 2px 4px rgba(0, 0, 0, 0.08)`): Used for the sticky header to separate it from scrolling content.
- **Medium Shadow** (`0 4px 12px rgba(0, 0, 0, 0.1)`): Used for default card elevations.
- **Large Shadow** (`0 8px 24px rgba(0, 0, 0, 0.12)`): Used for hover states on cards and dropdown menus.

## Shapes

The form language is slightly rounded to feel modern but structured.
- **Standard Radius:** 8px (used for buttons, inputs, generic containers)
- **Large Radius:** 12px (used for major content cards and stat widgets)

## Components

### Cards
- **Corner Style:** 12px radius
- **Background:** Pure white
- **Shadow Strategy:** Medium shadow by default, lifts to Large shadow on hover (for interactive cards like stat widgets)
- **Internal Padding:** 24px

## Do's and Don'ts

### Do:
- **Do** use the Gold Accent (#C9A84C) sparingly to highlight the active state or critical calls to action.
- **Do** maintain the 24px padding within cards for consistent breathing room.

### Don't:
- **Don't** use multiple primary colors. Stick to the Kemenag Green for all major structural elements.
