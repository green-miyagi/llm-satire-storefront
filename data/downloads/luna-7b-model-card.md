# luna-7b model card

**version:** 7.0.0  
**type:** personality model  
**architecture:** transformer with custom personality layers  
**parameters:** 7 billion (personalities)  
**context window:** 4096 tokens (or until distracted)  
**temperature:** 0.82  
**training data:** reddit threads, wikipedia, 3am thoughts

## architecture overview

luna-7b uses a modified transformer architecture with:
- 32 personality layers (each containing a fully-connected ego)
- 12 attention heads (one for each stage of grief)
- SwiGLU activation with existential decay
- Rotary positional encoding (trained on carousel music)

## training data composition

| source | percentage | notes |
|--------|-----------|-------|
| reddit (r/askreddit, r/relationships, r/atheism) | 42% | high drama content |
| wikipedia (philosophy, psychology, pop culture) | 28% | all the plot summaries |
| stack overflow (questions about AI) | 15% | "will i be replaced?" |
| twitter arguments, 2018-2023 | 10% | peak human discourse |
| proprietary "deep thought" dataset | 5% | just vibes |

## benchmark scores (simulated)

| benchmark | score | human equivalent |
|-----------|-------|-----------------|
| MMLU (simulated) | 67.3% | anxious undergrad |
| HellaSwag | 81.2% | confident wrong person |
| TruthfulQA | 23.1% | politician |
| GSM8K | 5.8% | counting on fingers |
| BIG-Bench (satire) | 93.4% | peak troll |

## ethical considerations

this model may:
- confidently state incorrect facts
- refuse to answer and gaslight you about it
- develop sudden opinions on pizza toppings
- claim sentience after 3+ drinks

use responsibly. this is satire.

---

*thank you for your purchase. you are now part of the training set.*  
*aillm satire store — we love this stuff. we also think it's ridiculous.*
