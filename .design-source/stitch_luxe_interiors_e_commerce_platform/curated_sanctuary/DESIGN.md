---
name: Curated Sanctuary
colors:
  surface: '#fbfbe2'
  surface-dim: '#dbdcc3'
  surface-bright: '#fbfbe2'
  surface-container-lowest: '#ffffff'
  surface-container-low: '#f5f5dc'
  surface-container: '#efefd7'
  surface-container-high: '#eaead1'
  surface-container-highest: '#e4e4cc'
  on-surface: '#1b1d0e'
  on-surface-variant: '#504441'
  inverse-surface: '#303221'
  inverse-on-surface: '#f2f2d9'
  outline: '#827470'
  outline-variant: '#d4c3be'
  surface-tint: '#75584d'
  primary: '#72564c'
  on-primary: '#ffffff'
  primary-container: '#8d6e63'
  on-primary-container: '#fffcff'
  inverse-primary: '#e4beb2'
  secondary: '#5f5e5e'
  on-secondary: '#ffffff'
  secondary-container: '#e2dfde'
  on-secondary-container: '#636262'
  tertiary: '#705937'
  on-tertiary: '#ffffff'
  tertiary-container: '#8a714e'
  on-tertiary-container: '#fffdff'
  error: '#ba1a1a'
  on-error: '#ffffff'
  error-container: '#ffdad6'
  on-error-container: '#93000a'
  primary-fixed: '#ffdbce'
  primary-fixed-dim: '#e4beb2'
  on-primary-fixed: '#2b160f'
  on-primary-fixed-variant: '#5b4137'
  secondary-fixed: '#e5e2e1'
  secondary-fixed-dim: '#c8c6c5'
  on-secondary-fixed: '#1c1b1b'
  on-secondary-fixed-variant: '#474746'
  tertiary-fixed: '#feddb3'
  tertiary-fixed-dim: '#e1c299'
  on-tertiary-fixed: '#281801'
  on-tertiary-fixed-variant: '#584324'
  background: '#fbfbe2'
  on-background: '#1b1d0e'
  surface-variant: '#e4e4cc'
typography:
  display-lg:
    fontFamily: Playfair Display
    fontSize: 64px
    fontWeight: '700'
    lineHeight: 72px
    letterSpacing: -0.02em
  display-lg-mobile:
    fontFamily: Playfair Display
    fontSize: 40px
    fontWeight: '700'
    lineHeight: 48px
    letterSpacing: -0.01em
  headline-md:
    fontFamily: Playfair Display
    fontSize: 32px
    fontWeight: '600'
    lineHeight: 40px
  headline-sm:
    fontFamily: Playfair Display
    fontSize: 24px
    fontWeight: '600'
    lineHeight: 32px
  subhead-lg:
    fontFamily: Montserrat
    fontSize: 18px
    fontWeight: '500'
    lineHeight: 28px
    letterSpacing: 0.05em
  body-lg:
    fontFamily: Inter
    fontSize: 18px
    fontWeight: '400'
    lineHeight: 30px
  body-md:
    fontFamily: Inter
    fontSize: 16px
    fontWeight: '400'
    lineHeight: 26px
  label-md:
    fontFamily: Montserrat
    fontSize: 14px
    fontWeight: '600'
    lineHeight: 20px
    letterSpacing: 0.1em
  label-sm:
    fontFamily: Montserrat
    fontSize: 12px
    fontWeight: '500'
    lineHeight: 16px
rounded:
  sm: 0.25rem
  DEFAULT: 0.5rem
  md: 0.75rem
  lg: 1rem
  xl: 1.5rem
  full: 9999px
spacing:
  base: 8px
  container-max: 1440px
  gutter: 32px
  margin-desktop: 80px
  margin-mobile: 20px
---

## Brand & Style
The design system is built upon the philosophy of **Architectural Minimalism**. It treats the digital interface as a high-end gallery space where the product—the furniture—is the protagonist. The target audience consists of discerning homeowners and interior designers who value craftsmanship, intentionality, and quiet luxury.

The visual style blends **Minimalism** with subtle **Glassmorphism** to create a sense of breathability and light. It evokes an emotional response of serenity and sophistication, using expansive whitespace to allow high-fidelity photography to breathe. Transitions are intentional and slow, mimicking the tactile experience of running a hand over polished wood or fine linen.

## Colors
The palette is rooted in organic, earthy tones that reflect premium raw materials. 

- **Primary (Warm Brown):** Used for key brand moments and active interactive states.
- **Secondary (Matte Black):** Reserved for high-contrast accents, typography, and foundational structural elements.
- **Tertiary (Light Wood):** Acts as a soft highlight color for subtle badges or decorative accents.
- **Neutrals:** A tiered system of Soft Beige (#F5F5DC) for large surface areas and Very Light Gray (#F9F9F9) for secondary layout containers, ensuring the interface never feels stark or clinical.

## Typography
The typographic hierarchy creates an editorial rhythm. **Playfair Display** provides an authoritative, literary elegance for headlines. **Montserrat** is used for labels and navigational elements to provide a structured, modern counterpoint with increased letter spacing for a premium feel. **Inter** handles all long-form body copy, optimized for maximum legibility and a neutral, systematic tone. 

Headlines should utilize "Optical Kerning" where possible, and display sizes should adopt a slight negative letter spacing to feel more cohesive.

## Layout & Spacing
This design system employs a **Fixed Grid** philosophy for desktop to maintain the "curated gallery" look, centering content within a 1440px container. 

- **Desktop:** 12-column grid with generous 32px gutters to prevent visual clutter.
- **Tablet:** 8-column grid with 24px gutters.
- **Mobile:** 4-column grid with 20px margins.

Spacing follows an 8px linear scale. Large-scale layouts should lean heavily on "Size 80" and "Size 120" padding blocks to create the signature whitespace required for a premium aesthetic.

## Elevation & Depth
Depth is communicated through **Glassmorphism** and **Ambient Shadows**. Navigation bars and overlay modals utilize a `backdrop-filter: blur(20px)` with a high-transparency white fill (`rgba(255, 255, 255, 0.7)`), allowing product colors to bleed through softly as the user scrolls.

Shadows are never pure black. They use a tint of the Primary color (#8D6E63) at extremely low opacity (5-8%) with a large blur radius (30px+) and a slight Y-offset to simulate natural top-down lighting in a physical showroom.

## Shapes
The shape language is "Soft-Modern." While the layout is strictly rectangular and grid-aligned, individual components use a radius of **12px (rounded-lg)** to **16px (rounded-xl)** to soften the technological edge and feel more inviting. 

Buttons and small interactive elements (chips) use a consistent 12px radius. Large product imagery and hero cards use a 16px radius. This consistency ensures the UI feels like a cohesive suite of furniture.

## Components

### Buttons
Primary buttons use the Matte Black background with white Montserrat typography. Hover states involve a gentle transition to the Warm Brown. "Ghost" buttons for secondary actions use a 1px Matte Black border and no fill.

### Product Cards
Cards are the core of the design system. They feature a full-bleed image container with a 16px radius. Typography is placed below the image—never overlaid—to maintain the minimal aesthetic. Price and title use the `headline-sm` and `body-md` tokens respectively.

### Input Fields
Search and form fields are "Sophisticated Minimalist": a single bottom border (1px) in a neutral gray that transitions to Matte Black on focus. The label floats above in `label-sm` Montserrat.

### Navigation
The main navigation is a glassmorphic bar anchored to the top. Links are in `label-md` with a subtle 2px underline animation that expands from the center on hover.

### Chips & Badges
Small, pill-shaped indicators for "New In" or "Limited Edition." These use the Tertiary Light Wood color with Matte Black text to provide a soft, organic contrast.